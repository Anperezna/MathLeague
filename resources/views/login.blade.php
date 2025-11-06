@extends('plantilla.plantilla')

@section('content')
    <link rel="stylesheet" href="CSS/login.css">
    
    <div class="auth-container" style="margin-top: 80px;">
        <div class="auth-box">
            <!-- Toggle Switch -->
            <div class="toggle-container">
                <button class="toggle-btn active" id="loginBtn" type="button">Iniciar sesión</button>
                <button class="toggle-btn" id="registerBtn" type="button">Registrar</button>
            </div>

            <!-- Login Form -->
            <div class="form-container active" id="loginForm">
                <h2>Iniciar Sesión</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" id="login-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="submit-btn">Iniciar sesión</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="form-container" id="registerForm">
                <h2>Registrar</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="register-username">Username</label>
                        <input type="text" id="register-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="register-mail">Mail</label>
                        <input type="email" id="register-mail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password-confirm">Verify Password</label>
                        <input type="password" id="register-password-confirm" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="submit-btn">Registrar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="JS/login.js"></script>
@endsection