<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ASTRA REPORT')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow">
        <div class="mx-auto flex max-w-5xl items-center justify-between p-4">
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="font-bold">ASTRA REPORT</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('dealers.index') }}" class="text-blue-600">Dealer</a>
                    <a href="{{ route('departments.index') }}" class="text-blue-600">Department</a>
                    <a href="{{ route('areas.index') }}" class="text-blue-600">Area</a>
                    <a href="{{ route('users.index') }}" class="text-blue-600">User</a>
                @endif
                @if (auth()->user()->isAdmin() || auth()->user()->isSupervisor())
                    <a href="{{ route('tasks.index') }}" class="text-blue-600">Task</a>
                    <a href="{{ route('reviews.index') }}" class="text-blue-600">Review</a>
                    <a href="{{ route('activity-logs.index') }}" class="text-blue-600">Log</a>
                @endif
                @if (auth()->user()->isDealer())
                    <a href="{{ route('submissions.index') }}" class="text-blue-600">Laporan Saya</a>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-5xl p-4">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>