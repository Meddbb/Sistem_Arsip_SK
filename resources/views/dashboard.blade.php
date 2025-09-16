<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Hero Section -->
        <div class="gradient-bg-hero text-white rounded-2xl mb-8 overflow-hidden shadow-2xl">
            <div class="relative px-6 py-12 sm:px-12 sm:py-16">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative max-w-7xl mx-auto text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold hero-text mb-4 animate-fade-in">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-xl sm:text-2xl text-blue-100 mb-8 animate-slide-up">
                        Kelola arsip surat keputusan dengan mudah dan efisien
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-bounce-in">
                        <a href="{{ route('sks.create') }}" class="btn-gradient px-8 py-3 text-lg font-semibold rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                            Upload SK Baru
                        </a>
                        <a href="{{ route('sks.index') }}" class="bg-white/20 backdrop-blur-sm text-white px-8 py-3 text-lg font-semibold rounded-xl border border-white/30 hover:bg-white/30 transition-all duration-300">
                            Lihat Daftar SK
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover animate-slide-up glow-primary">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-semibold text-gray-600 truncate">Total SK</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_sk'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover animate-slide-up glow-secondary" style="animation-delay: 0.1s">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-semibold text-gray-600 truncate">Total Divisi</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_divisi'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover animate-slide-up glow-accent" style="animation-delay: 0.2s">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-accent-400 to-accent-600 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-semibold text-gray-600 truncate">Total Pengguna</dt>
                                        <dd class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover animate-slide-up glow-primary" style="animation-delay: 0.3s">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-4m-6-6h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-semibold text-gray-600 truncate">SK Bulan Ini</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $stats['sk_bulan_ini'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent SKs -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden animate-fade-in">
                <div class="px-6 py-5 sm:px-8 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-xl leading-6 font-bold text-gray-900">SK Terbaru</h3>
                    <p class="mt-2 max-w-2xl text-sm text-gray-600">Daftar surat keputusan yang baru ditambahkan</p>
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($recent_sks as $sk)
                            <li class="px-4 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($sk->isPdf())
                                                <svg class="h-10 w-10 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="h-10 w-10 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $sk->judul }}</div>
                                            <div class="text-sm text-gray-500">{{ $sk->nomor }} • {{ $sk->division->nama }}</div>
                                            <div class="text-xs text-gray-400">Dibuat oleh {{ $sk->creator->name }} • {{ $sk->tanggal_terbit->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if($sk->isPdf())
                                            <a href="{{ route('sks.preview', $sk) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Preview</a>
                                        @endif
                                        <a href="{{ route('sks.download', $sk) }}" class="text-green-600 hover:text-green-900 text-sm font-medium">Unduh</a>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-8 text-center">
                                <p class="text-gray-500">Belum ada SK yang ditambahkan.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
                @if($recent_sks->count() > 0)
                    <div class="bg-gray-50 px-4 py-4 text-center">
                        <a href="{{ route('sks.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Lihat Semua SK</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
