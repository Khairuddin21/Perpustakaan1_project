<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        @auth
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between">
                    <div class="flex space-x-7">
                        <div>
                            <a href="{{ route('dashboard') }}" class="flex items-center py-4 px-2">
                                <span class="font-semibold text-gray-500 text-lg">Sistem Perpustakaan</span>
                            </a>
                        </div>
                        <!-- Primary Navbar items -->
                        <div class="hidden md:flex items-center space-x-1">
                            <a href="{{ route('dashboard') }}" class="py-4 px-2 text-gray-500 border-b-4 border-green-500 font-semibold">Dashboard</a>
                            
                            @if(auth()->user()->isAdmin())
                                <a href="#" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Users</a>
                                <a href="#" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Books</a>
                                <a href="#" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Categories</a>
                                <a href="#" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Reports</a>
                            @elseif(auth()->user()->isPustakawan())
                                <a href="#" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Peminjaman</a>
                                <a href="{{ route('returns.index') }}" class="py-4 px-2 text-gray-500 font-semibold hover:text-green-500 transition duration-300">Pengembalian</a>
                            @endif
                        </div>
                    </div>
                    <!-- Secondary Navbar items -->
                    <div class="hidden md:flex items-center space-x-3">
                        <div class="flex items-center space-x-3">
                            <span class="text-gray-500">{{ auth()->user()->name }}</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ucfirst(auth()->user()->role) }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-red-500 hover:text-white transition duration-300">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Page Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>