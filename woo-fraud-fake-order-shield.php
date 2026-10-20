<?php
/**
 * Plugin Name:       WooCommerce Anti-Fraud & Bot Order Shield
 * Plugin URI:        https://github.com/harunsekmen/woo-fraud-fake-order-shield
 * Description:       Non-intrusive rate limiting, IP reputation checks, and honeypot traps that disarm bots before payment gateway submission.
 * Version:           1.0.0
 * Author:            Harun Sekmen
 * Author URI:        https://github.com/harunsekmen
 * License:           GPL-3.0
 * Requires at least: 6.2
 * Requires PHP:      8.1
 * WC requires at least: 8.0
 */

defined('ABSPATH') || exit;

add_action('before_woocommerce_init', function () {
    if (class_exists(AutomatticWooCommerceUtilitiesFeaturesUtil::class)) {
        AutomatticWooCommerceUtilitiesFeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

require_once __DIR__ . '/includes/class-fraud-shield.php';

add_action('plugins_loaded', ['Woo_Fraud_Fake_Order_Shield', 'instance']);
