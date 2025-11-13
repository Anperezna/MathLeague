@extends('plantilla.plantilla')

@section('content')
    <link rel="stylesheet" href="CSS/login.css">
    
    
    <div class="auth-container" style="margin-top: 20px;">
        <div class="auth-box">
            <!-- Toggle Switch -->
            <div class="toggle-container">
                <button class="toggle-btn active" id="loginBtn" type="button">Log In</button>
                <button class="toggle-btn" id="registerBtn" type="button">Sign In</button>
            </div>

            <!-- Login Form -->
            <div class="form-container active" id="loginForm">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login-username"  style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Username</label>
                        <input type="text" id="login-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password"  style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="submit-btn">Log In</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="form-container" id="registerForm">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="register-username" style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Username</label>
                        <input type="text" id="register-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="register-mail" style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Mail</label>
                        <input type="email" id="register-mail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password" style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Password</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password-confirm" style="color: black; font-family: Lilita One, sans-serif; font-size: 22px;">Verify Password</label>
                        <input type="password" id="register-password-confirm" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="submit-btn">Sign In</button>
                </form>
            </div>
        </div>
    </div>
    <script src="JS/login.js"></script>
@endsection