@extends('layouts.auth')

@section('title', 'Masuk - Indonesia Luxe')

@section('content')
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl font-serif font-bold">IL</span>
                </div>
                <h1 class="text-2xl font-serif text-gray-900">Selamat Datang Kembali</h1>
                <p class="text-gray-500 text-sm mt-1">Masuk ke akun Indonesia Luxe Anda</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div
                    class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900"
                            placeholder="email@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" required
                            class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900"
                            placeholder="••••••••">
                        <button type="button" @click="show=!show"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition flex items-center justify-center gap-2 shadow-md shadow-amber-200">
                    <i data-lucide="log-in" class="w-5 h-5"></i> Masuk
                </button>
            </form>

            <div class="text-center mt-6 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-700 font-semibold">Daftar
                    sekarang</a>
            </div>
        </div>
    </div>
@endsection