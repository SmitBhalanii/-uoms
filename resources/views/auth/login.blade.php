<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'UOMS') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 35%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 50px; height: 50px; left: 50%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 90px; height: 90px; left: 65%; animation-delay: 3s; }
        .particle:nth-child(6) { width: 70px; height: 70px; left: 80%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-100px) rotate(180deg); opacity: 0.8; }
        }

        .login-container {
            display: flex;
            width: 90%;
            max-width: 1100px;
            height: 600px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Left side - Branding */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .brand-logo i {
            font-size: 60px;
            color: white;
        }

        .login-left h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .login-left p {
            font-size: 18px;
            opacity: 0.95;
            line-height: 1.6;
            max-width: 350px;
            position: relative;
            z-index: 1;
        }

        /* Right side - Form */
        .login-right {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 16px;
            color: #718096;
        }

        /* Session Status */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            font-size: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: #f7fafc;
        }

        .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .error-message {
            display: block;
            color: #e53e3e;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Remember Me Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #4a5568;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #667eea;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                width: 95%;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-left h1 {
                font-size: 32px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .form-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <div class="brand-logo">
                <i class="fas fa-university"></i>
            </div>
            <h1>UOMS</h1>
            <p>University Order Management System - Streamline your lab orders and inventory management</p>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Please login to your account</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') error @enderror" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email"
                        >
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            class="form-control @error('password') error @enderror" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        >
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="checkbox-group">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                    Log In
                </button>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
