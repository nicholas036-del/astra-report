<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Astra Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-200 p-4">
    <form method="POST" action="{{ route('login') }}"
          class="w-full max-w-sm space-y-4 rounded-xl bg-white p-8 shadow-lg">
        @csrf

        <div class="text-center">
            <h1 class="text-2xl font-bold text-blue-700">Astra Report</h1>
            <p class="text-sm text-gray-500">LMS Astra</p>
        </div>

        @error('email')
            <div class="rounded-lg bg-red-100 p-3 text-sm text-red-700">{{ $message }}</div>
        @enderror

        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus
               class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm
                      focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">

        <input type="password" name="password" placeholder="Password" required
               class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm
                      focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
            Ingat saya
        </label>

        <button type="submit"
                class="w-full rounded-lg bg-blue-600 p-2.5 text-sm font-semibold text-white
                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Login
        </button>
    </form>
</body>
</html>