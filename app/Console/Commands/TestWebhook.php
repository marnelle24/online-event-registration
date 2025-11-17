<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:webhook {reference_number?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test HitPay webhook with proper HMAC signature';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing HitPay Webhook');
        $this->line(str_repeat('=', 60));
        $this->newLine();

        // Get configuration
        // $webhookUrl = config('app.url') . '/payment/webhook';
        
        // Allow override with hardcoded salt for testing (optional)
        // $hardcodedSalt = 'JDJ5JDEwJDlWUkpRb0J6UHo3SXNqVnNPUm01NE93aGMuWmFFOVBuMEEvLmxaTXUxZWpXMHg1RENQVHlL';
       
        // Uncomment below to use hardcoded salt:
        $salt = 'JDJ5JDEwJDlWUkpRb0J6UHo3SXNqVnNPUm01NE93aGMuWmFFOVBuMEEvLmxaTXUxZWpXMHg1RENQVHlL';

        if (empty($salt)) 
        {
            $this->error('❌ Error: HITPAY_SALT not configured');
            $this->line('Add HITPAY_SALT to your .env file');
            return Command::FAILURE;
        }

        $webhookData = [
            "payment_id" => "9fb16953-dc7c-41b3-82c8-fad815fd243a",
            "payment_request_id" => "9fb16937-c617-4e7a-88cd-4c684b20e2f0",
            "phone" => "12312312",
            "amount" => "750.00",
            "currency" => "SGD",
            "status" => "completed",
            "reference_number" => "D6F2026GT_067",
            "hmac" => "bfbcf833683ddad83c71aebe05b1d138e087d64f4d7b66a07cd04c58abbbc9ab"
        ];

        $dataToVerify = $webhookData;

        //remove hmac from the webhook data
        unset($dataToVerify['hmac']);
        
        $this->line("Webhook Data: " . json_encode($dataToVerify, JSON_PRETTY_PRINT));
        $this->newLine();

        // Calculate
        $calculatedHmac = $this->generateSignature($salt, $dataToVerify);

        $this->line("Calculated HMAC: {$calculatedHmac}");
        $this->newLine();

        // Compare
        if ($calculatedHmac === $webhookData['hmac']) 
        {
            $this->info('✅ HMAC verification successful!');
        } 
        else 
        {
            $this->error('❌ HMAC mismatch!');
            $this->line("Expected: {$webhookData['hmac']}");
            $this->line("Got:      {$calculatedHmac}");
        }

        return Command::SUCCESS;



        try {
            // Send the webhook request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'User-Agent' => 'HitPay-Webhook-Test',
            ])->post($webhookUrl, $webhookData);

            $this->line('📥 Response:');
            $this->line("  HTTP Status: {$response->status()}");
            $this->line("  Response Body:");
            $this->line($response->body());
            $this->newLine();

            $this->line(str_repeat('=', 60));

            // Interpret results
            if ($response->successful()) {
                $this->info('✅ SUCCESS: Webhook processed successfully!');
                $this->line('   The HMAC signature was valid and payment was confirmed.');
                $this->newLine();
                $this->line('💡 Next Steps:');
                $this->line('   1. Check the registrant status in your database');
                $this->line('   2. Check if confirmation email was sent');
                $this->line('   3. Configure HitPay dashboard webhook URL');
            } elseif ($response->status() === 400) {
                $this->warn('⚠️  WARNING: Webhook rejected (400 Bad Request)');
                $this->line('   Possible reasons:');
                $this->line('   - HMAC signature verification failed');
                $this->line('   - Registrant not found for reference_number: ' . $referenceNumber);
                $this->line('   - Invalid payment status');
                $this->newLine();
                $this->line('💡 Check storage/logs/laravel.log for details');
            } elseif ($response->status() === 419) {
                $this->error('❌ ERROR: CSRF protection still blocking the webhook');
                $this->line('   Run: php artisan config:clear');
            } else {
                $this->error('❌ ERROR: Unexpected response code: ' . $response->status());
            }

            $this->newLine();

            return $response->successful() ? Command::SUCCESS : Command::FAILURE;

        } catch (\Exception $e) {
            $this->error('❌ ERROR: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    public function generateSignature($salt, array $data) 
    {   
        // Step 1: Sort by keys
        ksort($data);

        // Step 2: Concatenate VALUES only
        $dataString = implode('', array_values($data));

        // Step 3: Calculate HMAC
        $calculatedHmac = hash_hmac('sha256', $dataString, $salt); 

        return $calculatedHmac;
    }
}

