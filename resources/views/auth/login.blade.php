<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - ASTRA REPORT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-800 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-sm p-8">
        <h1 class="text-xl font-semibold text-center mb-1">ASTRA REPORT</h1>
        <p class="text-sm text-gray-500 text-center mb-6">Masuk untuk melanjutkan</p>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-800 px-4 py-3 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded border-gray-300 focus:border-slate-500 focus:ring-slate-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" for="password">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded border-gray-300 focus:border-slate-500 focus:ring-slate-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300">
                Ingat saya
            </label>
            <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-700 text-white rounded py-2 font-medium">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
