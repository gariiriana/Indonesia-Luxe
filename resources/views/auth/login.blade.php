@extends('layouts.auth')

@section('title', 'Masuk - Indonesia Luxe')

@section('content')
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            {{-- Top gradient bar --}}
            <div class="h-1.5 w-full" style="background: linear-gradient(to right, #F59E0B, #D97706, #B45309);"></div>

            <div class="p-8 md:p-10">
                {{-- Logo --}}
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group">
                        <div class="w-16 h-16 rounded-2xl bg-amber-500 flex items-center justify-center shadow-lg group-hover:scale-105 transition" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            <span class="text-white text-2xl font-serif font-bold">IL</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-serif text-gray-900">Selamat Datang Kembali</h1>
                            <p class="text-gray-400 text-sm mt-1">Masuk ke akun Indonesia Luxe Anda</p>
                        </div>
                    </a>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-start gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0 text-red-500"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                @if(session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Email Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900 text-sm transition outline-none"
                                   placeholder="email@example.com">
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password" required
                                   class="w-full pl-11 pr-12 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900 text-sm transition outline-none"
                                   placeholder="••••••••">
                            <button type="button" @click="show=!show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember"
                                   class="rounded border-gray-300 text-amber-500 focus:ring-amber-500 w-4 h-4">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            class="w-full text-white py-3.5 rounded-xl font-semibold transition flex items-center justify-center gap-2 shadow-lg"
                            style="background: linear-gradient(135deg, #F59E0B, #D97706);"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i data-lucide="log-in" class="w-5 h-5"></i> Masuk Sekarang
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-gray-400">atau</span>
                    </div>
                </div>

                {{-- Register Link --}}
                <div class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
                        Daftar sekarang
                    </a>
                </div>

                {{-- Back to Home --}}
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition inline-flex items-center gap-1">
                        <i data-lucide="arrow-left" class="w-3 h-3"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection