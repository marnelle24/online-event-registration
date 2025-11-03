<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px 0; text-align: center; background-color: #ffffff;">
                <table role="presentation" style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse; background-color: #ffffff; border: 1px solid #e5e5e5;">
                    <tr>
                        <td style="padding: 40px 30px; text-align: center; background-color: #4a5568;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">Password Reset Notification</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                Hello <strong>{{ $user->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                Your password has been reset by an administrator.
                            </p>
                            
                            <div style="background-color: #f9f9f9; border-left: 4px solid #4a5568; padding: 15px; margin: 20px 0;">
                                <p style="margin: 0 0 10px 0; color: #333333; font-size: 14px; font-weight: bold;">
                                    Your new password is:
                                </p>
                                <p style="margin: 0; color: #4a5568; font-size: 18px; font-family: monospace; font-weight: bold; word-break: break-all;">
                                    {{ $password }}
                                </p>
                            </div>
                            
                            <p style="margin: 20px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                <strong>For security reasons, please log in and change your password immediately after accessing your account.</strong>
                            </p>
                            
                            <table role="presentation" style="width: 100%; margin: 30px 0;">
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="{{ url('/login') }}" style="display: inline-block; padding: 12px 30px; background-color: #4a5568; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                            Log In Now
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 0 0; color: #666666; font-size: 14px; line-height: 1.6;">
                                <strong>Important:</strong> If you did not request this password reset, please contact support immediately.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px; background-color: #f9f9f9; border-top: 1px solid #e5e5e5; text-align: center;">
                            <p style="margin: 0; color: #666666; font-size: 14px;">
                                Thanks,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

