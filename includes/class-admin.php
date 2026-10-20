<?php
defined('ABSPATH') || exit;

/**
 * WordPress Admin Settings & Telemetry Dashboard
 *
 * @package WooFraudFakeOrderShield
 * @author  Harun Sekmen <sekmenwp@gmail.com>
 */
final class WooFraudFakeOrderShield_Admin {
    const OPTION_KEY = 'wffos_settings';
    private static ?self $instance = null;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('admin_menu', [$this, 'register_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_menu_page(): void {
        add_submenu_page(
            'woocommerce',
            esc_html__('Anti-Fraud & Bot Order Shield Settings', 'woo-fraud-fake-order-shield'),
            esc_html__('Fraud Shield', 'woo-fraud-fake-order-shield'),
            'manage_woocommerce',
            'woo-fraud-fake-order-shield-dashboard',
            [$this, 'render_dashboard_view']
        );
    }

    public function register_settings(): void {
        register_setting('wffos_settings_group', self::OPTION_KEY, [
            'type'              => 'array',
            'sanitize_callback' => [$this, 'sanitize_settings'],
            'default'           => ['enable_honeypot' => 1, 'max_attempts' => 5, 'block_disposable_emails' => 1]
        ]);
    }

    public function sanitize_settings($input): array {
        $output = [];
        if (is_array($input)) {
            foreach ($input as $key => $val) {
                $output[sanitize_key($key)] = is_numeric($val) ? (float)$val : sanitize_text_field($val);
            }
        }
        return $output;
    }

    public function render_dashboard_view(): void {
        if (!current_user_can('manage_woocommerce')) {
            return;
        }
        $settings = get_option(self::OPTION_KEY, ['enable_honeypot' => 1, 'max_attempts' => 5, 'block_disposable_emails' => 1]);
        require_once dirname(__DIR__) . '/templates/admin-dashboard.php';
    }
}

add_action('plugins_loaded', ['WooFraudFakeOrderShield_Admin', 'instance']);
