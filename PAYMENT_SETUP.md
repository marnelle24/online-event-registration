# Payment Gateway Setup Guide

This document provides instructions for setting up payment gateways for the Online Event Registration system.

## Overview

The payment microservice supports the following payment methods:
- **HitPay** - Credit/debit cards, PayNow, e-wallets
- **Stripe** - Credit/debit cards
- **PayPal** - PayPal accounts
- **Bank Transfer** - Direct bank transfer with manual verification

## Environment Configuration

Add the following variables to your `.env` file:

### HitPay Configuration
```env
HITPAY_ENABLED=false
HITPAY_SANDBOX=true
HITPAY_API_KEY=your_hitpay_api_key_here
HITPAY_SALT=your_hitpay_salt_here
```

**Setup Instructions:**
1. Sign up for HitPay at https://www.hit-pay.com/
2. Navigate to Settings > API Keys
3. Copy your API Key and Salt
4. For production, set `HITPAY_SANDBOX=false`

### Stripe Configuration
```env
STRIPE_ENABLED=false
STRIPE_PUBLIC_KEY=pk_test_your_stripe_public_key_here
STRIPE_SECRET_KEY=sk_test_your_stripe_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

**Setup Instructions:**
1. Sign up for Stripe at https://stripe.com/
2. Navigate to Developers > API Keys
3. Copy your Publishable Key and Secret Key
4. Set up webhook endpoint at `/payment/webhook`
5. Copy the webhook signing secret

### PayPal Configuration
```env
PAYPAL_ENABLED=false
PAYPAL_SANDBOX=true
PAYPAL_CLIENT_ID=your_paypal_client_id_here
PAYPAL_CLIENT_SECRET=your_paypal_client_secret_here
```

**Setup Instructions:**
1. Sign up for PayPal Developer at https://developer.paypal.com/
2. Create a new app in the Dashboard
3. Copy your Client ID and Secret
4. For production, set `PAYPAL_SANDBOX=false`

### Bank Transfer Configuration
```env
BANK_TRANSFER_ENABLED=true
BANK_NAME="Your Bank Name"
BANK_ACCOUNT_NAME="Your Organization Name"
BANK_ACCOUNT_NUMBER="XXXX-XXXX-XXXX"
BANK_SWIFT_CODE="SWIFTCODE"
```

**Setup Instructions:**
1. Fill in your organization's bank account details
2. These details will be shown to users when they select bank transfer

## Database Migration

Run the payment migration to add required columns:

```bash
php artisan migrate
```

This will add the following columns to the `registrants` table:
- `payment_gateway` - The payment gateway used
- `payment_transaction_id` - Transaction ID from the gateway
- `payment_metadata` - JSON data with payment details
- `payment_verified_by` - Admin who verified bank transfer
- `payment_verified_at` - Timestamp of verification
- `payment_initiated_at` - When payment was initiated
- `payment_completed_at` - When payment was completed

## API Routes

### Public Routes

#### Get Payment Methods
```
GET /api/payment-methods/{regCode}
```

Returns available payment methods for a registration.

**Response:**
```json
{
  "success": true,
  "payment_methods": [
    {
      "key": "hitpay",
      "name": "HitPay",
      "description": "Pay with credit/debit card, PayNow, or e-wallets",
      "enabled": true
    }
  ],
  "registrant": {
    "regCode": "EVENT2025_001",
    "amount": 100.00,
    "currency": "SGD"
  }
}
```

#### Process Payment
```
POST /api/process-payment/{regCode}
```

**Request Body:**
```json
{
  "payment_method": "hitpay"
}
```

**Response:**
```json
{
  "success": true,
  "payment_method": "hitpay",
  "data": {
    "status": "initiated",
    "reference_no": "EVENT2025_001",
    "payment_url": "https://gateway.url/pay/xxx",
    "redirect_url": "https://gateway.url/pay/xxx"
  }
}
```

### Payment Callbacks

#### Payment Callback (User Return)
```
GET /payment/callback
```

Handles user return from payment gateway after completing payment.

#### Payment Webhook
```
POST /payment/webhook
```

Handles asynchronous payment notifications from payment gateways.

### Admin Routes

#### Verify Bank Transfer
```
POST /admin/payments/verify-bank-transfer/{regCode}
```

Manually verify a bank transfer payment.

**Request Body:**
```json
{
  "verified": true,
  "notes": "Payment verified from bank statement"
}
```

## Usage Example

### Frontend Integration

```javascript
// 1. Get available payment methods
const response = await fetch(`/api/payment-methods/${regCode}`);
const data = await response.json();

// 2. Display payment methods to user
// User selects a payment method

// 3. Process payment
const paymentResponse = await fetch(`/api/process-payment/${regCode}`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    payment_method: 'stripe' // or 'hitpay', 'paypal', 'bank_transfer'
  })
});

const paymentData = await paymentResponse.json();

// 4. Redirect user to payment gateway
if (paymentData.success && paymentData.data.redirect_url) {
  window.location.href = paymentData.data.redirect_url;
} else if (paymentData.data.instructions) {
  // For bank transfer, show instructions modal
  showBankTransferModal(paymentData.data.instructions);
}
```

## Bank Transfer Flow

1. User selects bank transfer payment method
2. System displays step-by-step instructions with bank details
3. User completes bank transfer manually
4. User emails payment proof to configured email
5. Admin reviews payment in admin panel
6. Admin verifies payment using the API endpoint
7. System confirms registration and sends confirmation email

## Testing

### Test Mode

All payment gateways support sandbox/test modes:
- Set `HITPAY_SANDBOX=true` for HitPay test mode
- Use `pk_test_...` keys for Stripe test mode
- Set `PAYPAL_SANDBOX=true` for PayPal sandbox

### Test Cards

**Stripe Test Cards:**
- Success: `4242 4242 4242 4242`
- Decline: `4000 0000 0000 0002`

**PayPal Sandbox:**
- Use sandbox buyer accounts from PayPal Developer Dashboard

**HitPay Sandbox:**
- Follow HitPay documentation for test credentials

## Webhook URLs

Configure these webhook URLs in your payment gateway dashboards:

- **HitPay:** `https://yourdomain.com/payment/webhook`
- **Stripe:** `https://yourdomain.com/payment/webhook`
- **PayPal:** PayPal uses IPN, configure in your PayPal account settings

## Security

1. **Never commit API keys** - Keep them in `.env` file only
2. **Verify webhook signatures** - All gateways implement signature verification
3. **Use HTTPS** - Required for payment processing
4. **Validate amounts** - Server-side validation prevents tampering
5. **Log all transactions** - Payment logs stored in Laravel logs

## Troubleshooting

### Payment not confirmed after successful payment
- Check Laravel logs: `storage/logs/laravel.log`
- Verify webhook URL is accessible from payment gateway
- Ensure webhook signature verification is working

### Bank transfer not showing instructions
- Check bank transfer configuration in `.env`
- Verify `BANK_TRANSFER_ENABLED=true`

### Payment gateway not appearing
- Verify gateway is enabled in `.env`
- Check API credentials are correct
- Review Laravel logs for errors

## Support

For issues specific to payment gateways:
- **HitPay:** support@hit-pay.com
- **Stripe:** https://support.stripe.com/
- **PayPal:** https://www.paypal.com/support/

For system-specific issues, check the Laravel logs and contact your development team.

