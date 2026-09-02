<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Masuk Dashboard - WALHI Jawa Barat</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/fonts/webfonts/font-face.css') }}">

        <!-- Tailwind Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F4F1EA;
            }
            .btn-login {
                transition: all 0.15s ease;
            }
            .btn-login:hover {
                background-color: #1e5a3d !important;
            }
            .btn-login:active {
                transform: translate(2px, 2px);
                box-shadow: 1px 1px 0px 0px #1D1D1D !important;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
            <!-- Logo WALHI -->
            <div class="mb-8 text-center">
                <a href="/">
                    <img src="{{ asset('assets/images/resources/logo-2-walhi.png') }}" alt="WALHI Jawa Barat" style="height: 76px; object-fit: contain;" class="mx-auto drop-shadow-[2px_2px_0px_#1D1D1D]" />
                </a>
            </div>

            <!-- Card Box Neo-Brutalist -->
            <div style="background: white; border: 4px solid #1D1D1D; outline: 4px solid #1D1D1D; outline-offset: -4px; width: 100%; max-width: 440px;" class="p-8 md:p-10 shadow-[8px_8px_0px_0px_#1D1D1D]">
                <h2 style="font-family: Aspekta, sans-serif; font-weight: 800; font-size: 28px; text-align: center; text-transform: uppercase; color: #1D1D1D; letter-spacing: 0.5px; margin: 0 0 6px; line-height: 1.2;">DASHBOARD LOGIN</h2>
                <p style="font-family: Montserrat, sans-serif; font-size: 12px; font-weight: 700; text-align: center; color: #888; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 28px;">WALHI JAWA BARAT</p>
                
                <!-- Session Status -->
                @if(session('status'))
                    <div style="background: #256D4A; border: 2px solid #1D1D1D; color: white; padding: 12px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Errors -->
                @if ($errors->any())
                    <div style="background: #D95C3F; border: 2px solid #1D1D1D; color: white; padding: 12px; font-size: 13px; font-weight: 600; margin-bottom: 20px; display: flex; flex-direction: column; gap: 4px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf

                    <!-- Email -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <label for="email" style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #1D1D1D; letter-spacing: 0.5px;">Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="border: 2px solid #1D1D1D; padding: 12px; font-size: 14px; outline: none; background: white; font-family: 'Inter', sans-serif; color: #1D1D1D; border-radius: 0px;" class="focus:border-[#256D4A] focus:ring-0 focus:shadow-none" />
                    </div>

                    <!-- Password -->
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label for="password" style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #1D1D1D; letter-spacing: 0.5px;">Password *</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="font-family: 'Inter', sans-serif; font-size: 10px; color: #666; text-decoration: underline; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;" class="hover:text-[#256D4A]">Lupa Password?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" style="border: 2px solid #1D1D1D; padding: 12px; font-size: 14px; outline: none; background: white; font-family: 'Inter', sans-serif; color: #1D1D1D; border-radius: 0px;" class="focus:border-[#256D4A] focus:ring-0 focus:shadow-none" />
                    </div>

                    <!-- Remember Me -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input id="remember_me" type="checkbox" name="remember" style="border: 2px solid #1D1D1D; width: 16px; height: 16px; accent-color: #256D4A; cursor: pointer; border-radius: 0px;" />
                        <label for="remember_me" style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; color: #1D1D1D; cursor: pointer; select-none;">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" style="height: 52px; background: #256D4A; color: white; border: 2px solid #1D1D1D; font-weight: 700; font-size: 13px; text-transform: uppercase; cursor: pointer; font-family: 'Inter', sans-serif; letter-spacing: 0.5px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 0px;" class="btn-login shadow-[3px_3px_0px_0px_#1D1D1D]">
                        Masuk Ke Dashboard
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
