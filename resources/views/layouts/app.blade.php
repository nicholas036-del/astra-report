<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ASTRA REPORT')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    @auth
        @php
            $user = auth()->user();
            $canManage = $user->isAdmin() || $user->isSupervisor();
        @endphp

        <nav class="bg-white shadow">
            <div class="mx-auto flex max-w-5xl items-center justify-between p-4">
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="font-bold">ASTRA REPORT</a>

                    @if ($user->isAdmin())
                        @if (Route::has('dealers.index'))
                            <a href="{{ route('dealers.index') }}" class="text-blue-600 hover:underline">Dealer</a>
                        @endif
                        @if (Route::has('departments.index'))
                            <a href="{{ route('departments.index') }}" class="text-blue-600 hover:underline">Department</a>
                        @endif
                        @if (Route::has('areas.index'))
                            <a href="{{ route('areas.index') }}" class="text-blue-600 hover:underline">Area</a>
                        @endif
                        @if (Route::has('users.index'))
                            <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">User</a>
                        @endif
                    @endif

                    @if ($canManage)
                        @if (Route::has('tasks.index'))
                            <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline">Task</a>
                        @endif
                        @if (Route::has('reviews.index'))
                            <a href="{{ route('reviews.index') }}" class="text-blue-600 hover:underline">Review</a>
                        @endif
                        @if (Route::has('activity-logs.index'))
                            <a href="{{ route('activity-logs.index') }}" class="text-blue-600 hover:underline">Log</a>
                        @endif
                    @endif

                    @if ($user->isDealer() && Route::has('submissions.index'))
                        <a href="{{ route('submissions.index') }}" class="text-blue-600 hover:underline">Laporan Saya</a>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700 hover:underline">{{ $user->name }}</a>
                    @else
                        <span class="text-sm text-gray-700">{{ $user->name }}</span>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    @endauth

    <main class="mx-auto max-w-5xl p-4">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 p-3 text-red-800">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>