# Email Configuration Guide

This guide will help you configure email sending for the password reset functionality.

## Gmail SMTP Configuration

To send emails via Gmail, you need to configure your `.env` file with the following settings:

### Step 1: Enable 2-Step Verification (REQUIRED)

**If you see "The setting you are looking for is not available for your account":**

This means 2-Step Verification is not enabled. You MUST enable it first:

1. Go to: https://myaccount.google.com/security
2. Find **2-Step Verification** and click on it
3. Click **Get Started** and follow the prompts
4. You'll need to:
   - Verify your password
   - Add a phone number for verification codes
   - Verify the phone number
   - Optionally add a backup phone number

### Step 2: Generate Gmail App Password

**After 2-Step Verification is enabled:**

1. Go to: https://myaccount.google.com/apppasswords
2. You should now see the App passwords page
3. Select "Mail" from the dropdown
4. Select "Other (Custom name)" and type "Laravel App"
5. Click **Generate**
6. Copy the 16-character password (it will look like: `abcd efgh ijkl mnop`)

**Note:** If you still can't access App passwords after enabling 2-Step Verification, you might be using a Google Workspace account. Contact your administrator or use an alternative email provider (see below).

### Step 3: Update .env File

Add or update the following variables in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Important Notes:

- **MAIL_PASSWORD**: Use the 16-character app password generated in Step 1, NOT your regular Gmail password
- **MAIL_USERNAME**: Your full Gmail address (e.g., example@gmail.com)
- **MAIL_PORT**: 
  - Use `587` for TLS (recommended)
  - Use `465` for SSL (if TLS doesn't work)
- **MAIL_ENCRYPTION**: 
  - Use `tls` with port 587
  - Use `ssl` with port 465

### Alternative: Other Email Providers

#### Outlook/Office 365:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@outlook.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Mailtrap (for testing - FREE):
Mailtrap is perfect for testing emails without sending real emails. It's free and safe.

1. Sign up at: https://mailtrap.io/
2. Go to **Email Testing** → **Inboxes** → **SMTP Settings**
3. Copy the credentials and update your `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** With Mailtrap, emails won't actually be sent to users - they'll be captured in your Mailtrap inbox for testing. Perfect for development!

#### SendGrid (for production - FREE tier available):
1. Sign up at: https://sendgrid.com/
2. Create an API key in Settings → API Keys
3. Update your `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-verified-email@domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Mailgun (for production - FREE tier available):
1. Sign up at: https://www.mailgun.com/
2. Get your SMTP credentials from the dashboard
3. Update your `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-verified-email@domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4: Clear Configuration Cache

After updating your `.env` file, clear the configuration cache:

```bash
php artisan config:clear
php artisan config:cache
```

### Step 5: Test Email Sending

You can test if the email configuration is working by resetting a user's password through the admin panel.

## Troubleshooting

### Email not sending?

1. **Check .env file**: Make sure all MAIL_* variables are set correctly
2. **Clear cache**: Run `php artisan config:clear`
3. **Check logs**: Check `storage/logs/laravel.log` for error messages
4. **Gmail App Password**: Ensure you're using an app-specific password, not your regular password
5. **2-Step Verification**: Must be enabled to generate app passwords
6. **Check spam folder**: Emails might end up in spam

### Common Errors:

#### Error 535 - BadCredentials (Most Common):
**Error Message:** `535-5.7.8 Username and Password not accepted`

**Solutions:**
1. **Verify you're using an App Password, NOT your regular Gmail password**
   - Go to https://myaccount.google.com/apppasswords
   - Generate a new app password for "Mail"
   - Copy the 16-character password exactly (remove spaces if any)

2. **Check your .env file format:**
   ```env
   MAIL_USERNAME=marben101@gmail.com
   MAIL_PASSWORD=abcdefghijklmnop
   ```
   - Remove any quotes around the password
   - Remove spaces from the app password
   - Make sure there are no extra spaces or line breaks

3. **Ensure 2-Step Verification is enabled:**
   - App passwords only work if 2-Step Verification is enabled
   - Go to: https://myaccount.google.com/security
   - Enable 2-Step Verification if not already enabled

4. **Try generating a new App Password:**
   - Sometimes old app passwords expire or are revoked
   - Delete the old one and generate a fresh app password

5. **Clear config cache after updating .env:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

#### Other Common Errors:
- **"Authentication failed"**: Wrong password or not using app-specific password
- **"Connection timeout"**: Check firewall/network settings
- **"SSL/TLS error"**: Try switching between TLS and SSL encryption

## Security Notes

- Never commit your `.env` file to version control
- Use app-specific passwords, never use your main account password
- Regularly rotate your app passwords
- Consider using environment-specific email services for production

