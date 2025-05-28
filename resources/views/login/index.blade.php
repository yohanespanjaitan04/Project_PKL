<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPT PERPUS - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #4a5fc1;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4a5fc1;
            font-size: 14px;
        }

        .university-info h1 {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .university-info p {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            font-style: italic;
        }

        .perpus-title {
            color: white;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .welcome-title {
            text-align: center;
            margin-bottom: 8px;
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .welcome-subtitle {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #4a5fc1;
            background: white;
        }

        .form-input::placeholder {
            color: #adb5bd;
        }

        .password-container {
            position: relative;
        }

        .forgot-password {
            text-align: right;
            margin-top: 5px;
        }

        .forgot-password a {
            color: #4a5fc1;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4a5fc1;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }

        .sign-in-btn {
            width: 100%;
            background: #4a5fc1;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 25px;
        }

        .sign-in-btn:hover {
            background: #3d4fa3;
        }



        @media (max-width: 480px) {
            .header {
                padding: 10px 20px;
                flex-direction: column;
                gap: 10px;
            }

            .logo-section {
                flex-direction: column;
                text-align: center;
            }

            .university-info h1 {
                font-size: 20px;
            }

            .perpus-title {
                font-size: 24px;
            }

            .login-container {
                padding: 30px 25px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo-section">
            <div class="logo">
                UNDIP
            </div>
            <div class="university-info">
                <h1>UNIVERSITAS DIPONEGORO</h1>
                <p>The Excellent Research University</p>
            </div>
        </div>
        <div class="perpus-title">
            UPT PERPUS
        </div>
    </header>

    <main class="main-content">
        <div class="login-container">
            <h2 class="welcome-title">Welcome Back</h2>
            <p class="welcome-subtitle">Sign in to access your journal collections</p>
            
            <!-- Form Login - Bagian yang diperbaiki -->
<form action="/login" method="post">
    @csrf
    
    <!-- Tampilkan pesan error jika ada -->
    @if(session()->has('LoginError'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            {{ session('LoginError') }}
        </div>
    @endif

    <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input 
            type="email"  
            id="email" 
            name="email" 
            class="form-input @error('email') is-invalid @enderror" 
            placeholder="your@university.edu"
            required 
            value="{{ old('email') }}"
        >
        @error('email')
            <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="password-container">
            <input 
                type="password" 
                id="password" 
                name="password"
                class="form-input" 
                placeholder="Password"
                required
            >
        </div>
        @error('password')
            <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <button type="submit" class="sign-in-btn">Sign In</button>
</form>
        </div>
    </main>
</body>
</html>