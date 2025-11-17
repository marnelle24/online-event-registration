<?php

/**
 * HitPay Webhook Test Script
 * 
 * This script simulates a HitPay webhook request with proper HMAC signature
 * Usage: php artisan test:webhook
 * Or: php test-webhook.php <app_url> <hitpay_salt> <reference_number>
 */

// Check if running from command line arguments
if ($argc >= 3) {
    $webhookUrl = $argv[1] . '/payment/webhook';
    $salt = $argv[2];
    $referenceNumber = $argv[3] ?? 'BSS2026_TEST01';
} else {
    // Try to load from .env file
    if (!file_exists(__DIR__ . '/.env')) {
        echo "❌ Error: .env file not found\n";
        echo "Usage: php test-webhook.php <app_url> <hitpay_salt> <reference_number>\n";
        echo "Example: php test-webhook.php https://your-domain.ngrok-free.dev your_salt_here BSS2026_ABC123\n";
        exit(1);
    }
    
    require __DIR__.'/vendor/autoload.php';
    
    // Load environment variables
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    
    // Configuration
    $webhookUrl = $_ENV['APP_URL'] . '/payment/webhook';
    $salt = $_ENV['HITPAY_SALT'] ?? '';
    $referenceNumber = 'BSS2026_TEST01';
}

if (empty($salt)) {
    echo "❌ Error: HITPAY_SALT not configured in .env\n";
    exit(1);
}

// Sample webhook data (similar to what HitPay sends)
$webhookData = [
    'payment_id' => 'test-' . uniqid(),
    'payment_request_id' => 'pr-' . uniqid(),
    'phone' => '+65 91234567',
    'amount' => '25.00',
    'currency' => 'SGD',
    'status' => 'completed',
    'reference_number' => $referenceNumber, // Make sure this exists in your database
];

// Sort data alphabetically by key (HitPay requirement)
ksort($webhookData);

// Create data string for HMAC
$dataString = implode('', array_values($webhookData));

// Calculate HMAC
$hmac = hash_hmac('sha256', $dataString, $salt);

// Add HMAC to webhook data
$webhookData['hmac'] = $hmac;

echo "🔍 Testing HitPay Webhook\n";
echo str_repeat("=", 60) . "\n\n";

echo "Webhook URL: {$webhookUrl}\n";
echo "Salt configured: " . (empty($salt) ? '❌ NO' : '✅ YES') . "\n\n";

echo "📦 Webhook Payload:\n";
echo json_encode($webhookData, JSON_PRETTY_PRINT) . "\n\n";

echo "🔐 HMAC Calculation:\n";
echo "  Sorted Keys: " . implode(', ', array_keys($webhookData)) . "\n";
echo "  Data String: {$dataString}\n";
echo "  HMAC: {$hmac}\n\n";

echo "📤 Sending webhook request...\n\n";

// Send the webhook request
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhookData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'User-Agent: HitPay-Webhook-Test',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "📥 Response:\n";
echo "  HTTP Status: {$httpCode}\n";

if ($error) {
    echo "  ❌ Error: {$error}\n";
} else {
    echo "  Response Body:\n";
    $responseData = json_decode($response, true);
    if ($responseData) {
        echo json_encode($responseData, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo $response . "\n";
    }
}

echo "\n";
echo str_repeat("=", 60) . "\n";

// Interpret results
if ($httpCode === 200) {
    echo "✅ SUCCESS: Webhook processed successfully!\n";
    echo "   The HMAC signature was valid and payment was confirmed.\n";
} elseif ($httpCode === 400) {
    echo "⚠️  WARNING: Webhook rejected (400 Bad Request)\n";
    echo "   This could mean:\n";
    echo "   - HMAC signature verification failed\n";
    echo "   - Registrant not found for the reference_number\n";
    echo "   - Invalid payment status\n";
    echo "   Check storage/logs/laravel.log for details.\n";
} elseif ($httpCode === 419) {
    echo "❌ ERROR: CSRF protection still blocking the webhook\n";
    echo "   Make sure you've cleared caches: php artisan config:clear\n";
} else {
    echo "❌ ERROR: Unexpected response code: {$httpCode}\n";
}

echo "\n💡 Next Steps:\n";
echo "   1. Check storage/logs/laravel.log for detailed logs\n";
echo "   2. Ensure the reference_number '{$webhookData['reference_number']}' exists in your database\n";
echo "   3. Update this script with a real confirmationCode from your registrants table\n";
echo "   4. Configure your HitPay dashboard webhook URL to: {$webhookUrl}\n";
echo "\n";

