<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dainty Dream - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('iconDainty.png') }}">

    <!-- Open Graph / WhatsApp Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Dainty Dream - Login">
    <meta property="og:description" content="Silakan login ke sistem manajemen inventaris butik Dainty Dream. Kelola produk, kategori, supplier, customer, dan transaksi secara mudah dan aman.">
    <meta property="og:image" content="{{ asset('iconDainty.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('iconDainty.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta name="description" content="Silakan login ke sistem manajemen inventaris butik Dainty Dream. Kelola produk, kategori, supplier, customer, dan transaksi secara mudah dan aman.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #F8F9FA;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: url('{{ asset("BlueBlur.png") }}') no-repeat center;
            background-size: contain;
            z-index: 0;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: url('{{ asset("PinkBlur.png") }}') no-repeat center;
            background-size: contain;
            z-index: 0;
            pointer-events: none;
        }

        .login-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 25px;
            box-shadow: 0 30px 80px rgba(180, 120, 220, 0.2), 0 10px 40px rgba(200, 150, 250, 0.15);
            padding: 20px 20px;
            width: 100%;
            max-width: 300px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.9);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo {
            width: 100px;
            height: 70px;
            margin: 0 auto 20px;
            display: block;
            object-fit: contain;
        }

        .logo-text {
            display: none;
        }

        .login-header h1 {
            font-size: 12px;
            color: #44474E;
            font-weight: 500;
            letter-spacing: 2px;
            /* margin-bottom: 3px; */
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            margin-bottom: 8px;
            color: #635979;
            font-weight: 500;
            font-size: 11px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .input-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid #C4C6CF;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.3s ease;
            background: #FFFFFF;
            color: #5A4A7A;
            font-family: 'Inter', sans-serif;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #C4C6CF;
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(167, 139, 204, 0.1);
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder,
        input[type="text"]::placeholder {
            color: #C4C6CF;
        }

        .password-input-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #C4C6CF;
            font-size: 16px;
            border: none;
            background: none;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #74777F;
        }

        .checkbox-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            font-size: 13px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #635979;
        }

        .checkbox-label {
            color: #44474E;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
        }

        .forgot-link {
            color: #475F86;
            text-decoration: none;
            font-weight: 200;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #475F86;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: #AEC6F2;
            color: #475F86;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 550;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(174, 198, 242, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(174, 198, 242, 0.45);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn i {
            font-size: 16px;
        }

        .error-message {
            background: #FFE8E8;
            color: #A04040;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #F5A8A8;
            font-size: 13px;
        }

        .success-message {
            background: #E8F5FF;
            color: #5B8BAA;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #A78BCC;
            font-size: 13px;
        }

        .auth-footer {
            text-align: center;
            color: #635979;
            font-size: 12px;
            margin-top: 20px;
            font-weight: 200;
        }

        .bottom-nav {
            display: none;
        }

        .copyright {
            display: none;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 40px 25px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 14px;
            }

            .logo {
                width: 100px;
                height: 65px;
            }

            .logo-text {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <img src="{{ asset('iconDainty.png') }}" alt="Dainty Dream" class="logo">
                <h1>INVENTORY MANAGEMENT</h1>
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="error-message">{{ $error }}</div>
                @endforeach
            @endif

            @if (session('msg'))
                <div class="success-message">{{ session('msg') }}</div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Business Email</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <img src="{{ asset('IconMessage.png') }}" alt="Email">
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="owner@daintydream.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Access Key</label>
                    <div class="password-input-wrapper">
                        <div class="input-icon">
                            <img src="{{ asset('IconKey.png') }}" alt="Key">
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="checkbox-wrapper">
                    <div class="checkbox-group">
                        <input type="checkbox" id="stay-cloud" name="stay_cloud">
                        <label for="stay-cloud" class="checkbox-label">Stay in the cloud</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot Key?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span>Open Boutique</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                Authorized Access Only. Request Access
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
