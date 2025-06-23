?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; background: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .resend-section { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; }
        .text-center { text-align: center; }
        .info-box { background: #e7f3ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Verify Your Email</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="info-box">
            <strong>Check your email!</strong><br>
            We've sent a verification email to <strong>{{ session('email') }}</strong><br>
            You can either:
            <ul style="margin: 10px 0;">
                <li>Enter the 6-digit OTP code below, OR</li>
                <li>Click the verification link in the email</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            
            <div class="form-group">
                <label for="otp">Enter 6-digit OTP:</label>
                <input type="text" id="otp" name="otp" maxlength="6" placeholder="Enter OTP" required>
                @error('otp')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Verify Email</button>
        </form>

        <div class="resend-section">
            <p>Didn't receive the email?</p>
            <form method="POST" action="{{ route('otp.resend') }}" style="display: inline;">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button type="submit" style="background: #6c757d;">Resend OTP & Link</button>
            </form>
        </div>
    </div>
</body>
</html>
