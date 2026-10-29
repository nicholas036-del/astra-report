<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Astra Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-200">
    <form method="POST" action="{{ route('login') }}"
          class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm space-y-4">
        @csrf

        <div class="text-center">
            <h1 class="text-2xl font-bold text-blue-700">Astra Report</h1>
            <p class="text-sm text-gray-500">LMS Astra</p>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm
                          focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200"
                   autocomplete="email" autofocus>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password"
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm
                          focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200"
                   autocomplete="current-password">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
            Ingat saya
        </label>

        <button type="submit"
                class="w-full rounded-lg bg-blue-600 p-2.5 text-sm font-semibold text-white
                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Masuk
        </button>
    </form>
</body>
</html>