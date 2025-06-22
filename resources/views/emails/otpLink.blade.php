?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6;
            color: #333;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #f9f9f9;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .otp-code { 
            font-size: 32px; 
            font-weight: bold; 
            color: #007bff; 
            text-align: center; 
            padding: 20px; 
            background: #f8f9fa; 
            border: 2px dashed #007bff; 
            margin: 20px 0;
            border-radius: 8px;
            letter-spacing: 3px;
        }
        .verify-button {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .verify-button:hover {
            background: #218838;
        }
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
        }
        .divider span {
            background: white;
            padding: 0 20px;
            color: #666;
        }
        .option-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }
        .option-title {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2 style="color: #007bff; text-align: center;">Email Verification</h2>
            <p>Hello! Please verify your email address using either of the following methods:</p>
            
            <div class="option-box">
                <div class="option-title">Option 1: Enter OTP Code</div>
                <p>Use this 6-digit verification code:</p>
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <div class="divider">
                <span>OR</span>
            </div>

            <div class="option-box">
                <div class="option-title">Option 2: Click Verification Link</div>
                <p>Click the button below to verify your email instantly:</p>
                <div style="text-align: center;">
                    <a href="{{ $verificationLink }}" class="verify-button">
                        Verify Email Address
                    </a>
                </div>
                <p style="font-size: 12px; color: #666;">
                    If the button doesn't work, copy and paste this link in your browser:<br>
                    <a href="{{ $verificationLink }}">{{ $verificationLink }}</a>
                </p>
            </div>

            <div class="footer">
                <p><strong>Important:</strong></p>
                <ul>
                    <li>This verification will expire in <strong>10 minutes</strong></li>
                    <li>You only need to use ONE of the above methods</li>
                    <li>If you didn't create an account, please ignore this email</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
