# Quick Webhook Test Guide

## ⚡ Fast Setup (5 minutes)

### 1. Add to `.env`
```env
HITPAY_API_KEY=your_api_key
HITPAY_SALT=your_salt_secret
HITPAY_SANDBOX=true
HITPAY_ENABLED=true
APP_URL=https://your-domain.ngrok-free.dev
```

### 2. Clear Caches
```bash
php artisan config:clear && php artisan cache:clear
```

### 3. Test Locally
```bash
# Simple test (should return JSON, not 419)
curl -X POST http://127.0.0.1:8000/payment/webhook \
  -H "Content-Type: application/json" \
  -d '{"test":"data"}'

# Expected: {"success":false,"error":"..."}
# NOT: 419 Page Expired
```

### 4. Test with Real Data
```bash
# Use a real confirmationCode from your database
php artisan test:webhook BSS2026_67372F
```

### 5. Configure HitPay Dashboard
- Go to: HitPay Dashboard → API Keys
- Copy the **Salt** (not API Key)
- Set Webhook URL: `https://your-domain.ngrok-free.dev/payment/webhook`
- Enable webhook

### 6. Make Test Payment
1. Register for a programme
2. Click "Pay with PayNow"
3. Complete payment in sandbox
4. Check logs: `tail -f storage/logs/laravel.log`
5. Check HitPay dashboard webhook status

---

## ✅ Success Indicators

- Local curl returns JSON (not 419) ✅
- `php artisan test:webhook` works ✅
- HitPay webhook status shows "Success" ✅
- Registrant status updated to "confirmed" ✅
- Confirmation email received ✅

---

## 🐛 Quick Fixes

### Still getting 419?
```bash
php artisan config:clear
php artisan cache:clear
# Restart Laravel server
```

### "HITPAY_SALT not configured"?
- Get Salt from HitPay Dashboard → API Keys
- Add to `.env`: `HITPAY_SALT=your_salt_here`
- Run: `php artisan config:clear`

### Webhook fails in HitPay dashboard?
- Check `storage/logs/laravel.log`
- Verify ngrok is running
- Test ngrok: `https://your-domain.ngrok-free.dev/payment/webhook`

---

## 📚 Full Documentation
- `WEBHOOK-FIX-SUMMARY.md` - Detailed fix information
- `HITPAY-WEBHOOK-TESTING-GUIDE.md` - Complete testing guide

