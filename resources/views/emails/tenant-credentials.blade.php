<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:1.45; margin:0; padding:0; background-color:#0b1220; color:#e5e7eb;">
    <div style="max-width:560px; margin:0 auto; padding:24px;">
        <div style="background-color:#182232; border:1px solid #263249; border-radius:8px; padding:20px;">
            <div style="text-align:center; padding-bottom:16px; margin-bottom:16px; border-bottom:1px solid #263249;">
                <img src="{{ $message->embed(public_path('images/logos/logo2.png')) }}" alt="EZRent Logo" style="height:48px; width:auto; display:block; margin:0 auto;">
            </div>
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width:100%; margin:0 0 10px 0;">
                <tr>
                    <td style="font-size:12px; font-weight:bold; color:#e5e7eb; text-align:left;">Welcome to EZRent</td>
                    <td style="font-size:12px; color:#9ca3af; text-align:right;">{{ now()->format('M d, Y') }}</td>
                </tr>
            </table>

            <p style="margin:0 0 12px 0;">Hello {{ $tenantName }},</p>
            <p style="margin:0 0 12px 0;">We’re excited to have you on board. Your account is ready — here’s what you can do right away:</p>
            <ul style="margin:0 0 16px 18px; padding:0;">
                <li style="margin:0 0 6px 0;">View lease details and monthly rent</li>
                <li style="margin:0 0 6px 0;">See payment history and upcoming dues</li>
                <li style="margin:0 0 6px 0;">Submit maintenance requests</li>
                <li style="margin:0 0 6px 0;">Update your contact information</li>
            </ul>
            <p style="margin:0 0 16px 0;">Your login details:</p>

            <div style="background:#0f1726; border:1px solid #263249; border-radius:6px; padding:12px; margin-bottom:16px;">
                <div style="margin-bottom:6px;"><span style="color:#9ca3af;">Email:</span> <strong style="color:#e5e7eb;">{{ $email }}</strong></div>
                <div><span style="color:#9ca3af;">Password:</span> <strong style="color:#e5e7eb;">{{ $password }}</strong></div>
            </div>

            <div style="text-align:center; margin:18px 0 8px 0;">
                <a href="{{ $loginUrl }}" style="color:#e5e7eb; text-decoration:none; border:1px solid #4b5563; padding:8px 14px; border-radius:6px; display:inline-block;">Access your account</a>
            </div>

            <p style="margin:8px 0 0 0; color:#9ca3af;">Direct link: <a href="{{ $loginUrl }}" style="color:#e5e7eb;">{{ $loginUrl }}</a></p>
            <p style="margin:8px 0 0 0; color:#9ca3af;">Tip: After you sign in, please change your password from Profile → Security.</p>
        </div>

        <p style="text-align:center; color:#9ca3af; margin:14px 0 0 0;">If you have any questions, please contact our support team.</p>
    </div>
</body>
</html>
