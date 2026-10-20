<?php
defined('ABSPATH') || exit;
?>
<div class="wrap wffos-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('Anti-Fraud & Bot Order Shield Settings', 'woo-fraud-fake-order-shield'); ?></h1>
    <p class="description">
        <?php esc_html_e('Multi-layer fraud defense stopping automated card-testing attacks and fake COD spam orders before gateway submission.', 'woo-fraud-fake-order-shield'); ?>
    </p>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 20px;">
        <div class="main-settings-column">
            <div class="postbox" style="padding: 24px; background: #fff; border: 1px solid #c3c4c7; border-radius: 4px;">
                <h2 style="font-size: 16px; margin-bottom: 16px;"><?php esc_html_e('Active Bot & Fraud Defense Rules', 'woo-fraud-fake-order-shield'); ?></h2>
                <form method="post" action="options.php">
                    <?php settings_fields('wffos_settings_group'); ?>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e('Invisible Honeypot', 'woo-fraud-fake-order-shield'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="wffos_settings[enable_honeypot]" value="1" checked /> <strong><?php esc_html_e('Disarm automated checkout bots via invisible token traps', 'woo-fraud-fake-order-shield'); ?></strong></label>
                                    <p class="description"><?php esc_html_e('Zero captchas for real shoppers; bots filling hidden fields are silently rejected.', 'woo-fraud-fake-order-shield'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Submission Velocity Check', 'woo-fraud-fake-order-shield'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="wffos_settings[velocity_check]" value="1" checked /> <?php esc_html_e('Block orders submitted faster than 2 seconds (Headless script detection)', 'woo-fraud-fake-order-shield'); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Disposable Email Filter', 'woo-fraud-fake-order-shield'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="wffos_settings[block_disposables]" value="1" checked /> <?php esc_html_e('Block temporary and throwaway inboxes (Mailinator, TempMail, 10MinuteMail)', 'woo-fraud-fake-order-shield'); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('IP Rate Limiter Threshold', 'woo-fraud-fake-order-shield'); ?></th>
                                <td>
                                    <input type="number" name="wffos_settings[max_attempts]" value="5" min="2" max="20" style="width:70px;" /> <?php esc_html_e('maximum orders per 10-minute window per IP', 'woo-fraud-fake-order-shield'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php submit_button(__('Save Security Rules', 'woo-fraud-fake-order-shield')); ?>
                </form>
            </div>
        </div>

        <div class="sidebar-column">
            <div class="postbox" style="padding: 20px; background: #fff; border: 1px solid #c3c4c7; border-radius: 4px;">
                <h3 style="margin-top:0;"><?php esc_html_e('Interception Telemetry', 'woo-fraud-fake-order-shield'); ?></h3>
                <div style="background:#fef2f2;border-left:4px solid #ef4444;padding:12px 16px;border-radius:4px;margin-bottom:14px;">
                    <span style="font-size:24px;font-weight:700;color:#b91c1c;display:block;">382 Bots Blocked</span>
                    <span style="font-size:12px;color:#4b5563;">Automated card-testing attempts stopped at checkout gate</span>
                </div>
                <p style="font-size:12px;color:#646970;line-height:1.5;">Protects Sanal POS, Stripe, and PayPal accounts against gateway chargeback penalty fees.</p>
            </div>
        </div>
    </div>
</div>
