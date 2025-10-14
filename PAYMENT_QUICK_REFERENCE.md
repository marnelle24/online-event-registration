# Payment Service Quick Reference

## Quick Start

### 1. Environment Setup (5 minutes)
```bash
# Copy payment config to .env
# See PAYMENT_SETUP.md for full details

# Run migration
php artisan migrate
```

### 2. Frontend Integration (10 minutes)
```blade
<!-- In your payment page -->
<x-payment-methods 
    :reg-code="$registrant->regCode"
    :amount="$registrant->netAmount"
    :currency="'SGD'"
/>

@push('scripts')
<script src="{{ asset('js/payment-service.js') }}"></script>
@endpush
```

### 3. Done! 🎉

## Common Operations

### Enable a Payment Gateway

**In .env:**
```env
STRIPE_ENABLED=true
STRIPE_PUBLIC_KEY=pk_test_xxx
STRIPE_SECRET_KEY=sk_test_xxx
```

### Get Available Payment Methods

**API Call:**
```javascript
GET /api/payment-methods/{regCode}
```

**Response:**
```json
{
  "success": true,
  "payment_methods": [...]
}
```

### Process Payment

**API Call:**
```javascript
POST /api/process-payment/{regCode}
Content-Type: application/json

{
  "payment_method": "stripe"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "redirect_url": "https://checkout.stripe.com/..."
  }
}
```

### Verify Bank Transfer (Admin)

**API Call:**
```javascript
POST /admin/payments/verify-bank-transfer/{regCode}
Content-Type: application/json

{
  "verified": true,
  "notes": "Payment verified"
}
```

## Payment Status Values

| Status | Description |
|--------|-------------|
| `pending` | Payment not yet initiated |
| `pending_verification` | Bank transfer awaiting verification |
| `paid` | Payment successful |
| `free` | Free event (no payment) |
| `group_member` | Group member (paid by main registrant) |
| `rejected` | Payment rejected |

## Route Reference

### Public Routes
```
GET  /registration/payment/{regCode}  - Show payment page
GET  /payment/callback                - Payment callback
POST /payment/webhook                 - Payment webhook
```

### API Routes
```
GET  /api/payment-methods/{regCode}        - Get payment methods
POST /api/process-payment/{regCode}        - Process payment
```

### Admin Routes
```
POST /admin/payments/verify-bank-transfer/{regCode}  - Verify payment
```

## Service Methods

### PaymentService

```php
use App\Services\Payment\PaymentService;

$service = new PaymentService();

// Process payment
$result = $service->processPayment($registrant, 'stripe');

// Verify callback
$result = $service->verifyPaymentCallback('stripe', $callbackData);

// Confirm payment
$success = $service->confirmPayment($referenceNo);

// Get payment methods
$methods = $service->getAvailablePaymentMethods();
```

### Gateway Methods

```php
use App\Services\Payment\Gateways\StripeGateway;

$gateway = new StripeGateway();

// Initiate payment
$result = $gateway->initiatePayment($paymentData);

// Verify payment
$result = $gateway->verifyPayment($callbackData);

// Get status
$status = $gateway->getPaymentStatus($referenceNo);

// Refund
$result = $gateway->refundPayment($referenceNo, $amount);
```

## JavaScript Helper

```javascript
// Initialize
const paymentService = new PaymentService('EVENT2025_001');

// Get methods
const data = await paymentService.getPaymentMethods();

// Process payment
await paymentService.processPayment('stripe');

// Initiate payment (auto-detects redirect vs modal)
await paymentService.initiatePayment('bank_transfer');
```

## Testing

### Test Cards

**Stripe:**
- Success: `4242 4242 4242 4242`
- Decline: `4000 0000 0000 0002`
- 3D Secure: `4000 0025 0000 3155`

### Test PayPal
Use sandbox accounts from PayPal Developer Dashboard

### Test Bank Transfer
1. Select bank transfer
2. Note the reference number
3. Login as admin
4. Verify payment manually

## Configuration Files

| File | Purpose |
|------|---------|
| `config/services.php` | Gateway credentials |
| `.env` | Environment variables |
| `PAYMENT_SETUP.md` | Full setup guide |
| `PAYMENT_IMPLEMENTATION_SUMMARY.md` | Architecture docs |

## Log Files

```bash
# View payment logs
tail -f storage/logs/laravel.log | grep -i payment

# View recent errors
tail -100 storage/logs/laravel.log | grep ERROR
```

## Common Issues

### Payment not confirming
```bash
# Check logs
tail -100 storage/logs/laravel.log

# Verify webhook URL
curl https://yourdomain.com/payment/webhook
```

### Gateway not showing
```bash
# Check .env
grep STRIPE_ENABLED .env

# Clear config cache
php artisan config:clear
```

### Database errors
```bash
# Run migrations
php artisan migrate

# Check migration status
php artisan migrate:status
```

## Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# View routes
php artisan route:list | grep payment

# Test API endpoint
curl -X GET http://localhost/api/payment-methods/EVENT2025_001

# Check service configuration
php artisan tinker
>>> config('services.stripe')
```

## Database Queries

```sql
-- Get pending payments
SELECT * FROM registrants WHERE paymentStatus = 'pending';

-- Get bank transfer awaiting verification
SELECT * FROM registrants WHERE paymentStatus = 'pending_verification';

-- Get payments by gateway
SELECT payment_gateway, COUNT(*) FROM registrants GROUP BY payment_gateway;

-- Get recent payments
SELECT regCode, payment_gateway, paymentStatus, payment_completed_at 
FROM registrants 
WHERE payment_completed_at IS NOT NULL 
ORDER BY payment_completed_at DESC 
LIMIT 10;
```

## Support Contacts

| Gateway | Support |
|---------|---------|
| HitPay | support@hit-pay.com |
| Stripe | https://support.stripe.com/ |
| PayPal | https://www.paypal.com/support/ |

## Next Steps

1. ✅ Run migration
2. ✅ Configure payment gateways in .env
3. ✅ Test in sandbox mode
4. ✅ Integrate payment component in your views
5. ✅ Configure webhooks
6. ✅ Test each payment method
7. ✅ Switch to production mode
8. ✅ Monitor payments

## Resources

- Full Setup: `PAYMENT_SETUP.md`
- Architecture: `PAYMENT_IMPLEMENTATION_SUMMARY.md`
- Service Code: `app/Services/Payment/`
- Frontend Helper: `resources/js/payment-service.js`
- UI Component: `resources/views/components/payment-methods.blade.php`

---

**Need Help?** Check the logs first: `storage/logs/laravel.log`

