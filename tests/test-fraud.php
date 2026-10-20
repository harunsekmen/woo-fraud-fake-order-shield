<?php
require_once __DIR__ . '/bootstrap.php';
require_once dirname(__DIR__) . '/includes/class-fraud-shield.php';

class Mock_WP_Error_Fraud {
    public array $errors = [];
    public function add($code, $message) { $this->errors[$code] = $message; }
}

echo "Testing Woo_Fraud_Fake_Order_Shield (Deep Logic)...
";
$shield = Woo_Fraud_Fake_Order_Shield::instance();

// Test 1: Honeypot trap
$_POST['wffos_hp_token'] = 'bot_filled_value';
$err1 = new Mock_WP_Error_Fraud();
$shield->inspect_checkout_request(['billing_email' => 'real@example.com'], $err1);
assert(isset($err1->errors['bot_detected']), "Honeypot token must trigger bot_detected error");
unset($_POST['wffos_hp_token']);

// Test 2: Rapid form submission velocity (<2 seconds)
$_POST['wffos_form_time'] = time(); // Submitted in 0 seconds
$err2 = new Mock_WP_Error_Fraud();
$shield->inspect_checkout_request(['billing_email' => 'real@example.com'], $err2);
assert(isset($err2->errors['velocity_fail']), "Instant submission must trigger velocity_fail");
unset($_POST['wffos_form_time']);

// Test 3: Disposable email domain rejection
$_POST['wffos_form_time'] = time() - 10; // Normal submission time
$err3 = new Mock_WP_Error_Fraud();
$shield->inspect_checkout_request(['billing_email' => 'spammer@tempmail.com'], $err3);
assert(isset($err3->errors['disposable_email']), "Disposable email must be rejected");

// Test 4: Legitimate email submission
$err4 = new Mock_WP_Error_Fraud();
$shield->inspect_checkout_request(['billing_email' => 'customer@gmail.com'], $err4);
assert(empty($err4->errors), "Legitimate customer must have 0 errors");

echo "PASS: Woo_Fraud_Fake_Order_Shield deep assertions passed.
";
