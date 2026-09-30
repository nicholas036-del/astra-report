<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        @error('email')
            <div>{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Password" required>

        <label>
            <input type="checkbox" name="remember"> Ingat saya
        </label>

        <button type="submit">Login</button>
    </form>
</body>
</html>