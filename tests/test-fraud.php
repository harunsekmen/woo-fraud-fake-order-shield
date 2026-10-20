<?php
require_once __DIR__ . '/bootstrap.php';

require_once dirname(__DIR__) . '/includes/class-fraud-shield.php';

echo "Testing Woo_Fraud_Fake_Order_Shield...
";
$shield = Woo_Fraud_Fake_Order_Shield::instance();
assert($shield instanceof Woo_Fraud_Fake_Order_Shield, "Instance check");
echo "PASS: Woo_Fraud_Fake_Order_Shield verified.
";
