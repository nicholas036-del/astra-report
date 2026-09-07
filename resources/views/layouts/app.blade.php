<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ASTRA REPORT')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">
    <nav class="bg-slate-800 text-white">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <span class="font-semibold tracking-wide">ASTRA REPORT</span>

                @auth
                    @if(auth()->user()->isSupervisor())
                        <div class="flex gap-4 text-sm">
                            <a href="{{ route('supervisor.tasks.index') }}" class="hover:text-slate-300">Tugas</a>
                            <a href="{{ route('supervisor.reviews.index') }}" class="hover:text-slate-300">Periksa Tugas</a>
                            <a href="{{ route('supervisor.dealers.index') }}" class="hover:text-slate-300">Dealer</a>
                            <a href="{{ route('supervisor.departments.index') }}" class="hover:text-slate-300">Departemen</a>
                            <a href="{{ route('supervisor.areas.index') }}" class="hover:text-slate-300">Area</a>
                        </div>
                    @else
                        <div class="flex gap-4 text-sm">
                            <a href="{{ route('dealer.tasks.index') }}" class="hover:text-slate-300">Daftar Tugas</a>
                        </div>
                    @endif
                @endauth
            </div>

            @auth
                <div class="flex items-center gap-3 text-sm">
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-slate-700 hover:bg-slate-600 px-3 py-1 rounded">Keluar</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-800 px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
