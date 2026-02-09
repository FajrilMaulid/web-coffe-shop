<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coffee Shop Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <div class="coffee-cup-icon">
                    <div class="steam"></div>
                    <div class="steam"></div>
                    <div class="steam"></div>
                    ☕
                </div>
                <h1 class="login-title">Coffee Shop</h1>
                <p class="login-subtitle">Sistem Administrasi</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>⚠️</strong>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="form-icon">📧</div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="form-icon">🔒</div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary login-btn">
                    Masuk ☕
                </button>
            </form>

            <div class="login-footer">
                <p>&copy; {{ date('Y') }} Coffee Shop Admin System</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
