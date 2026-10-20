<?php
defined('ABSPATH') || exit;

final class Woo_Fraud_Fake_Order_Shield {
    const VERSION = '1.0.0';
    private static ?self $instance = null;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('woocommerce_after_checkout_validation', [$this, 'inspect_checkout_request'], 5, 2);
        add_action('woocommerce_after_order_notes', [$this, 'inject_honeypot_field']);
    }

    public function inject_honeypot_field(): void {
        echo '<div style="display:none !important;" aria-hidden="true">';
        echo '<input type="text" name="wffos_verification_token" tabindex="-1" autocomplete="off" value="" />';
        echo '</div>';
    }

    public function inspect_checkout_request($data, $errors): void {
        if (!empty($_POST['wffos_verification_token'])) {
            $errors->add('bot_detected', esc_html__('Spam tespit edildi. Lütfen tekrar deneyiniz.', 'woo-fraud-fake-order-shield'));
            return;
        }

        $ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'));
        $transient_key = 'wffos_rate_' . md5($ip);
        $attempts = (int) get_transient($transient_key);

        if ($attempts >= 5) {
            $errors->add('rate_limited', esc_html__('Çok fazla sipariş denemesi yapıldı. Lütfen 10 dakika sonra tekrar deneyiniz.', 'woo-fraud-fake-order-shield'));
            return;
        }

        set_transient($transient_key, $attempts + 1, 600);
    }
}
