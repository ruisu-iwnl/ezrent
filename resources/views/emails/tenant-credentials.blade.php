<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to EZRent</title>
    @if(request()->boolean('preview', false))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:1.45; margin:0; padding:0; background-color:#0b1220; color:#e5e7eb; }
        .wrap { max-width:560px; margin:0 auto; padding:24px; }
        .border-divider { border-color:#263249; }
        .bg-card { background-color:#182232; }
        .card { background-color:#182232; border:1px solid #263249; border-radius:8px; padding:20px; }
        .text-primary { color:#e5e7eb; }
        .text-secondary { color:#9ca3af; }
        .btn-primary { background-color:#1f2937; color:#e5e7eb; padding:8px 14px; border-radius:6px; display:inline-block; text-decoration:none; border:1px solid #4b5563; }
        .btn-primary:hover { background-color:#111827; }
    </style>
</head>
<body>
    
    <div class="wrap">
        <div style="border-bottom: 1px solid; padding-bottom: 15px; margin-bottom: 20px;" class="border-divider">
            <img src="{{ asset('images/logos/logo2.png') }}" alt="EZRent Logo" style="height: 48px; width: auto; margin: 0 auto 10px auto;">
        </div>

    <div style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <h1 style="font-size: 12px; font-weight: bold; margin: 0;" class="text-primary">Welcome to EZRent</h1>
            <span style="font-size: 12px;" class="text-secondary">{{ now()->format('M d, Y') }}</span>
        </div>
        <p style="font-size: 12px; margin: 0 0 15px 0;" class="text-primary">Hello {{ $tenantName }},</p>
        <p style="font-size: 12px; margin: 0;" class="text-primary">We're excited to have you as part of our community. Your tenant account has been successfully created and you can now access your dashboard.</p>
    </div>

    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 12px; font-weight: bold; margin: 0 0 10px 0;" class="text-primary">What You Can Do</h2>
        <ul style="font-size: 12px; margin: 0; padding-left: 15px;" class="text-primary">
            <li style="margin-bottom: 4px;">View your lease details and payment history</li>
            <li style="margin-bottom: 4px;">Track upcoming rent payments and due dates</li>
            <li style="margin-bottom: 4px;">Submit maintenance requests and communicate with management</li>
            <li style="margin-bottom: 4px;">Update your contact information and preferences</li>
            <li style="margin-bottom: 0;">Access important documents and notices</li>
        </ul>
    </div>

    <div style="padding: 15px; margin-bottom: 20px;" class="card">
        <h2 style="font-size: 12px; font-weight: bold; margin: 0 0 10px 0;" class="text-primary">Account Information</h2>
        
        <div style="margin-bottom: 8px;">
            <span style="font-size: 12px;" class="text-secondary">Email:</span>
            <span style="font-size: 12px; font-weight: bold;" class="text-primary">{{ $email }}</span>
        </div>
        
        <div style="margin-bottom: 0;">
            <span style="font-size: 12px;" class="text-secondary">Password:</span>
            <span style="font-size: 12px; font-weight: bold;" class="text-primary" id="password-display">{{ str_repeat('•', strlen($password)) }}</span>
            <button type="button" onclick="togglePassword()" style="font-size: 10px; margin-left: 8px; background: none; border: none; color: #666; cursor: pointer; text-decoration: underline;">Show</button>
        </div>
        
        <script>
            function togglePassword() {
                const display = document.getElementById('password-display');
                const button = event.target;
                
                if (display.textContent.includes('•')) {
                    display.textContent = '{{ $password }}';
                    button.textContent = 'Hide';
                } else {
                    display.textContent = '{{ str_repeat('•', strlen($password)) }}';
                    button.textContent = 'Show';
                }
            }
        </script>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ $loginUrl }}" class="btn-primary">
            Access Your Account
        </a>
    </div>

    <div style="border-top: 1px solid; padding-top: 15px;" class="border-divider">
        <p style="font-size: 12px; margin: 0 0 8px 0;" class="text-secondary">Direct login link:</p>
        <p style="font-size: 12px; margin: 0 0 15px 0; word-break: break-all;" class="text-primary">{{ $loginUrl }}</p>
        
        <p style="font-size: 12px; margin: 0;" class="text-secondary">If you have any questions, please contact our support team.</p>
    </div>
    </div>

</body>
</html>