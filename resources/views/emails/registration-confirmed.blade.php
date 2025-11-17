<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmed</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .confirmation-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #14b8a6;
        }
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            width: 40%;
            color: #64748b;
        }
        .info-value {
            width: 60%;
            color: #1e293b;
        }
        .button {
            display: inline-block;
            background: #14b8a6;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            margin-top: 20px;
        }
        .highlight {
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">✅ Registration Confirmed!</h1>
        <p style="margin: 10px 0 0 0;">Payment Successful</p>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $registrant->firstName }} {{ $registrant->lastName }}</strong>,</p>

        <p>Thank you for your registration! We're pleased to confirm that your payment has been processed successfully and your registration is now <span class="highlight">CONFIRMED</span>.</p>

        <div class="confirmation-box">
            <h3 style="margin-top: 0; color: #14b8a6;">Registration Details</h3>
            
            <div class="info-row">
                <div class="info-label">Confirmation Code:</div>
                <div class="info-value"><strong>{{ $registrant->confirmationCode }}</strong></div>
            </div>

            @if($registrant->regCode)
            <div class="info-row">
                <div class="info-label">Registration Code:</div>
                <div class="info-value"><strong>{{ $registrant->regCode }}</strong></div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-label">Programme:</div>
                <div class="info-value">{{ $programme->title }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Date & Time:</div>
                <div class="info-value">{{ $programme->programmeDates }}<br>{{ $programme->programmeTimes }}</div>
            </div>

            @if($programme->location)
            <div class="info-row">
                <div class="info-label">Location:</div>
                <div class="info-value">{{ $programme->location }}</div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-label">Amount Paid:</div>
                <div class="info-value">${{ number_format($registrant->netAmount, 2) }} SGD</div>
            </div>

            <div class="info-row">
                <div class="info-label">Payment Status:</div>
                <div class="info-value"><span style="color: #10b981; font-weight: bold;">✓ PAID</span></div>
            </div>
        </div>

        @if($registrant->groupRegistrationID)
        <div style="background: #dbeafe; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0;"><strong>👥 Group Registration:</strong> This is a group registration. All group members have been confirmed.</p>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $confirmationUrl }}" class="button">View Full Confirmation</a>
        </div>

        <div style="background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b;">
            <p style="margin: 0;"><strong>⚠️ Important:</strong> Please keep this email for your records. You may be required to present your confirmation code at the event.</p>
        </div>

        <p style="margin-top: 30px;">If you have any questions or need to make changes to your registration, please contact us at <a href="mailto:{{ $programme->contactEmail ?? config('mail.from.address') }}">{{ $programme->contactEmail ?? config('mail.from.address') }}</a>.</p>

        <p>We look forward to seeing you at the event!</p>

        <p style="margin-top: 30px;">
            Best regards,<br>
            <strong>{{ $programme->ministry->name ?? 'Event Team' }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>This is an automated confirmation email. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>

