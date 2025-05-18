<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
        }
        .code-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }
        .verification-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #2563eb;
            margin: 15px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.avif') }}" alt="Company Logo" class="logo">
        <h1>Your Verification Code</h1>
    </div>

    <p>Hello {{ $user->name }},</p>
    
    <p>We received a request to authenticate your account. Please use the following verification code:</p>
    
    <div class="code-container">
        <p>Your verification code is:</p>
        <div class="verification-code">{{ $user->code }}</div>
        <p>This code will expire in 2 minutes.</p>
    </div>
    
    <p>If you didn't request this code, please ignore this email or contact our support team immediately.</p>
    
    <p>Thank you,<br>
    The {{ config('app.name') }} Team</p>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>
            <a href="{{ config('app.url') }}" style="color: #6b7280; text-decoration: none;">Visit our website</a> | 
            <a href="{{ config('app.url') }}/contact" style="color: #6b7280; text-decoration: none;">Contact Support</a>
        </p>
    </div>
</body>
</html>