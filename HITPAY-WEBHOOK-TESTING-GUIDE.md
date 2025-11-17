# HitPay Webhook Testing Guide

> **🎉 UPDATE: CSRF Issue Fixed!** 
> The webhook endpoint was returning 419 "Page Expired" errors. This has been resolved by adding CSRF exclusions in `bootstrap/app.php`.
> See `WEBHOOK-FIX-SUMMARY.md` for detailed fix information.

## Overview

The HitPay payment flow has been fully implemented with the following features:
1. ✅ Payment initiation via HitPay API
2. ✅ Webhook HMAC verification
3. ✅ Payment confirmation and status updates
4. ✅ Email notification to registrant
5. ✅ Redirect to confirmation page

## Complete Flow

```
┌─────────────────────────────────────────────────────────────────┐
│ 1. User Completes Registration Form                             │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 2. User Clicks "Pay with PayNow" on Payment Page                │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 3. HitPayGateway::initiatePayment()                             │
│    - Creates payment request in HitPay                          │
│    - Returns payment URL                                         │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 4. User Redirected to HitPay Payment Page                       │
│    - User completes payment (PayNow/Card)                       │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 5. HitPay Sends Webhook to Your Server (Background)             │
│    POST /payment/webhook                                         │
│    - Contains HMAC signature for verification                   │
│    - Status: "completed" or "success"                           │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 6. RegistrantController::paymentWebhook()                       │
│    - Receives webhook payload                                    │
│    - Calls PaymentService::verifyPaymentCallback()             │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 7. HitPayGateway::verifyPayment()                               │
│    - Verifies HMAC signature                                     │
│    - Validates payment status                                    │
│    - Returns verification result                                 │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 8. PaymentService::confirmPayment()                             │
│    - Updates registrant status to "confirmed"                   │
│    - Sets payment status to "paid"                              │
│    - Generates registration code (regCode)                      │
│    - Updates group members (if group registration)              │
│    - Increments promocode/promotion counters                    │
│    - Sends confirmation email                                    │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 9. User Receives Confirmation Email                             │
│    - Contains registration details                              │
│    - Confirmation code                                           │
│    - Event details                                               │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 10. HitPay Redirects User Back to Your Site                     │
│     GET /payment/callback?status=completed&reference_number=... │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 11. RegistrantController::paymentCallback()                     │
│     - Simple status check (no HMAC verification needed)         │
│     - Redirects to confirmation page                             │
└───────────────────┬─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────┐
│ 12. User Sees Confirmation Page                                 │
│     - "Payment successful! Your registration is confirmed."     │
└─────────────────────────────────────────────────────────────────┘
```

## Prerequisites

### 1. Ensure CSRF Exclusion is in Place

The webhook route must be excluded from CSRF protection. This is already done in `routes/web.php`:

```php
Route::post('/payment/webhook', [RegistrantController::class, 'paymentWebhook'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('payment.webhook');
```

### 2. Configure HitPay Credentials

Make sure your `.env` has:

```env
HITPAY_API_KEY=your_api_key_here
HITPAY_SALT=your_salt_secret_here
HITPAY_SANDBOX=true
HITPAY_ENABLED=true
```

**Important:** The `HITPAY_SALT` is the **HMAC secret key** from your HitPay dashboard. This is used to verify webhook authenticity.

### 3. Configure Mail Settings

Ensure mail is configured in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_EMAIL=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

For testing, you can use [Mailtrap](https://mailtrap.io/) or [MailHog](https://github.com/mailhog/MailHog).

### 4. Configure Webhook URL in HitPay Dashboard

1. Login to HitPay Sandbox Dashboard
2. Go to Settings → Payment Methods → API Keys
3. Set Webhook URL to: `https://your-ngrok-domain.ngrok-free.dev/payment/webhook`
4. Make sure the webhook is enabled

## Testing Steps

### Step 1: Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 2: Start Your Servers

```bash
# Terminal 1: Laravel
php artisan serve --host=127.0.0.1 --port=8000

# Terminal 2: ngrok
ngrok http 8000 --domain=your-domain.ngrok-free.dev
```

### Step 3: Update `.env` with ngrok URL

```env
APP_URL=https://your-domain.ngrok-free.dev
```

Then clear config again:
```bash
php artisan config:clear
```

### Step 4: Make a Test Registration

1. Navigate to a programme: `https://your-domain.ngrok-free.dev/programme/{programmeCode}`
2. Click "Register Now"
3. Fill out the registration form
4. On the payment page, click "Pay with PayNow"
5. You'll be redirected to HitPay sandbox
6. Complete the test payment

### Step 5: Monitor Logs

Watch your Laravel logs in real-time:

```bash
tail -f storage/logs/laravel.log
```

You should see:
1. `HitPay payment initialization successful`
2. `Webhook received` (with headers and payload)
3. `HitPay webhook verification started`
4. `HMAC Calculation Details` (shows HMAC comparison)
5. `HitPay payment verification successful`
6. `Payment confirmed successfully`
7. `Registration confirmation email sent`

### Step 6: Check HitPay Dashboard

1. Go to HitPay Dashboard → Webhooks
2. You should see the webhook status as **Success** (not Failed)
3. If failed, click on it to see the error details

### Step 7: Verify Email Sent

Check your mail inbox (or Mailtrap/MailHog) for the confirmation email.

### Step 8: Check Database

Verify the registrant record was updated:

```sql
SELECT 
    confirmationCode,
    regCode,
    regStatus,
    paymentStatus,
    payment_completed_at,
    payment_verified_at,
    emailStatus
FROM registrants 
WHERE confirmationCode = 'YOUR_CONFIRMATION_CODE';
```

Expected values:
- `regStatus`: `'confirmed'`
- `paymentStatus`: `'paid'`
- `payment_completed_at`: timestamp
- `payment_verified_at`: timestamp
- `emailStatus`: `true` or `1`
- `regCode`: `'PROGRAMCODE_001'` (or next number)

## Troubleshooting

### Issue 1: Webhook Returns 419 (Page Expired)

**Cause:** CSRF protection is blocking the webhook.

**Fix:** Ensure the route in `routes/web.php` has `->withoutMiddleware([VerifyCsrfToken::class])`.

---

### Issue 2: "Invalid HMAC signature"

**Cause:** The HMAC calculation doesn't match HitPay's signature.

**Fix:**
1. Verify `HITPAY_SALT` in `.env` matches the secret from HitPay dashboard
2. Check the logs for `HMAC Calculation Details`
3. Compare `calculated_hmac` vs `provided_hmac`

**Debug:** The logs now show:
- Sorted keys
- Sorted values
- Data string
- Both HMACs for comparison

---

### Issue 3: Email Not Sent

**Cause:** Mail configuration issues or email sending failed.

**Fix:**
1. Check `storage/logs/laravel.log` for email errors
2. Verify mail configuration in `.env`
3. Test mail with: `php artisan tinker` then `Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));`

---

### Issue 4: Webhook Not Received

**Cause:** ngrok not exposing the webhook endpoint.

**Fix:**
1. Verify ngrok is running: Check ngrok dashboard at `http://localhost:4040`
2. Ensure HitPay webhook URL is correct (must match your ngrok URL)
3. Test webhook manually:
   ```bash
   curl -X POST https://your-domain.ngrok-free.dev/payment/webhook \
     -H "Content-Type: application/json" \
     -d '{"test": "data"}'
   ```

---

### Issue 5: Payment Confirmed But User Not Redirected

**Cause:** The browser callback redirect is separate from the webhook.

**Explanation:** 
- The webhook (background) confirms the payment
- The browser redirect just shows the user the result
- Both work independently

**Verify:** Check logs - webhook should process even if redirect doesn't work.

---

## Key Improvements Made

1. **Enhanced HMAC Verification:**
   - Detailed logging of HMAC calculation steps
   - Shows exactly why HMAC verification fails (if it does)
   - Validates salt configuration

2. **Better Webhook Responses:**
   - Returns proper HTTP status codes (200, 400, 500)
   - Returns JSON responses with clear messages
   - Logs all webhook activity

3. **Email Notifications:**
   - Beautiful HTML email template
   - Includes all registration details
   - Sent automatically after payment confirmation
   - Error handling to prevent payment confirmation failure

4. **Robust Error Handling:**
   - Try-catch blocks at every critical point
   - Detailed error logging
   - Graceful degradation (e.g., email failure doesn't stop payment confirmation)

5. **Comprehensive Logging:**
   - Every step logged with context
   - Easy to trace issues in logs
   - HMAC calculation details for debugging

## Next Steps

1. Test the complete flow in sandbox
2. Monitor logs during testing
3. Verify email delivery
4. Check HitPay dashboard for webhook status
5. Once everything works in sandbox, switch to production:
   - Update `HITPAY_SANDBOX=false`
   - Update API keys to production keys
   - Update webhook URL in production HitPay dashboard

## Support

If you encounter issues:
1. Check `storage/logs/laravel.log` for detailed error messages
2. Check HitPay dashboard webhook logs
3. Verify all configuration settings in `.env`
4. Use the ngrok web interface (`http://localhost:4040`) to inspect requests

