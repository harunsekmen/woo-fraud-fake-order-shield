<?php
defined('ABSPATH') || exit;

/**
 * Enterprise Anti-Fraud & Bot Order Shield
 * Stops card-testing automated attacks and fake COD submissions without user friction.
 *
 * @package WooFraudFakeOrderShield
 * @author  Harun Sekmen <sekmenwp@gmail.com>
 */
final class Woo_Fraud_Fake_Order_Shield {
    const VERSION = '1.0.0';
    private static ?self $instance = null;

    private array $disposable_domains = [
        'mailinator.com', '10minutemail.com', 'tempmail.com', 'guerrillamail.com',
        'throwawaymail.com', 'yopmail.com', 'trashmail.com'
    ];

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('woocommerce_after_checkout_validation', [$this, 'inspect_checkout_request'], 5, 2);
        add_action('woocommerce_after_order_notes', [$this, 'inject_security_tokens']);
    }

    public function inject_security_tokens(): void {
        $timestamp = time();
        echo '<div style="display:none !important;" aria-hidden="true">';
        echo '<input type="text" name="wffos_hp_token" tabindex="-1" autocomplete="off" value="" />';
        echo '<input type="hidden" name="wffos_form_time" value="' . esc_attr($timestamp) . '" />';
        echo '</div>';
    }

    public function inspect_checkout_request($data, $errors): void {
        // Check 1: Honeypot trap
        if (!empty($_POST['wffos_hp_token'])) {
            $errors->add('bot_detected', esc_html__('Bot submission detected.', 'woo-fraud-fake-order-shield'));
            return;
        }

        // Check 2: Form submission velocity (< 2 seconds implies automated script)
        $form_time = isset($_POST['wffos_form_time']) ? absint(wp_unslash($_POST['wffos_form_time'])) : 0;
        if ($form_time > 0 && (time() - $form_time) < 2) {
            $errors->add('velocity_fail', esc_html__('Submission too rapid. Please retry.', 'woo-fraud-fake-order-shield'));
            return;
        }

        // Check 3: Disposable email domain blocker
        $email = sanitize_email($data['billing_email'] ?? '');
        if (!empty($email) && str_contains($email, '@')) {
            $parts = explode('@', $email);
            $domain = strtolower(end($parts));
            if (in_array($domain, $this->disposable_domains, true)) {
                $errors->add('disposable_email', esc_html__('Please provide a permanent, valid email address.', 'woo-fraud-fake-order-shield'));
                return;
            }
        }

        // Check 4: IP Rate Limiting (max 5 orders per 10 minutes)
        $ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'));
        $key = 'wffos_ip_' . md5($ip);
        $attempts = (int) get_transient($key);

        if ($attempts >= 5) {
            $errors->add('rate_limit', esc_html__('Too many checkout attempts from your network. Please wait 10 minutes.', 'woo-fraud-fake-order-shield'));
            return;
        }

        set_transient($key, $attempts + 1, 600);
    }
}
