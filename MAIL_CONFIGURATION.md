# Email Configuration Guide

This guide will help you configure email sending for the password reset functionality.

## Gmail SMTP Configuration

To send emails via Gmail, you need to configure your `.env` file with the following settings:

### Step 1: Generate Gmail App Password

Since Gmail requires app-specific passwords for SMTP access, follow these steps:

1. Go to your Google Account settings: https://myaccount.google.com/
2. Navigate to **Security** → **2-Step Verification** (enable it if not already enabled)
3. Scroll down to **App passwords**
4. Generate a new app password for "Mail"
5. Copy the 16-character password (it will look like: `abcd efgh ijkl mnop`)

### Step 2: Update .env File

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

#### Mailtrap (for testing):
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

### Step 3: Clear Configuration Cache

After updating your `.env` file, clear the configuration cache:

```bash
php artisan config:clear
php artisan config:cache
```

### Step 4: Test Email Sending

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

- **"Authentication failed"**: Wrong password or not using app-specific password
- **"Connection timeout"**: Check firewall/network settings
- **"SSL/TLS error"**: Try switching between TLS and SSL encryption

## Security Notes

- Never commit your `.env` file to version control
- Use app-specific passwords, never use your main account password
- Regularly rotate your app passwords
- Consider using environment-specific email services for production

