@extends('layouts.auth')

@section('title', 'Daftar - Indonesia Luxe')

@section('content')
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            {{-- Top gradient bar --}}
            <div class="h-1.5 w-full" style="background: linear-gradient(to right, #F59E0B, #D97706, #B45309);"></div>

            <div class="p-8 md:p-10">
                {{-- Logo --}}
                <div class="text-center mb-7">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 group">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center shadow-lg group-hover:scale-105 transition" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            <span class="text-white text-xl font-serif font-bold">IL</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-serif text-gray-900">Buat Akun Baru</h1>
                            <p class="text-gray-400 text-sm mt-0.5">Bergabung dengan Indonesia Luxe hari ini</p>
                        </div>
                    </a>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $err)
                            <li class="flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i> {{ $err }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Role Selector --}}
                    <div x-data="{ role: '{{ old('role', 'user') }}' }">
                        <input type="hidden" name="role" :value="role">
                        <label class="block text-sm font-semibold text-gray-700 mb-2.5">Daftar sebagai</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="role='user'"
                                    :class="role === 'user' ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-sm' : 'border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="border-2 rounded-xl p-3.5 text-center transition cursor-pointer">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mx-auto mb-2"
                                     :class="role === 'user' ? 'bg-amber-500' : 'bg-gray-100'">
                                    <i data-lucide="user" class="w-4 h-4" :class="role === 'user' ? 'text-white' : 'text-gray-400'"></i>
                                </div>
                                <p class="text-sm font-semibold">Wisatawan</p>
                                <p class="text-xs mt-0.5 opacity-60">Beli & booking tour</p>
                            </button>
                            <button type="button" @click="role='vendor'"
                                    :class="role === 'vendor' ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-sm' : 'border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="border-2 rounded-xl p-3.5 text-center transition cursor-pointer">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mx-auto mb-2"
                                     :class="role === 'vendor' ? 'bg-amber-500' : 'bg-gray-100'">
                                    <i data-lucide="briefcase" class="w-4 h-4" :class="role === 'vendor' ? 'text-white' : 'text-gray-400'"></i>
                                </div>
                                <p class="text-sm font-semibold">Vendor</p>
                                <p class="text-xs mt-0.5 opacity-60">Jual paket tour</p>
                            </button>
                        </div>
                    </div>

                    {{-- Name Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition outline-none"
                                   placeholder="Nama Anda">
                        </div>
                    </div>

                    {{-- Email Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition outline-none"
                                   placeholder="email@example.com">
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                            <input :type="show ? 'text' : 'password'" name="password" required minlength="8"
                                   class="w-full pl-11 pr-12 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition outline-none"
                                   placeholder="Min. 8 karakter">
                            <button type="button" @click="show=!show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password Field --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                            <input type="password" name="password_confirmation" required
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm transition outline-none"
                                   placeholder="Ulangi password">
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start gap-2">
                        <input type="checkbox" required id="terms"
                               class="rounded border-gray-300 text-amber-500 focus:ring-amber-500 w-4 h-4 mt-0.5 shrink-0">
                        <label for="terms" class="text-xs text-gray-500 leading-relaxed">
                            Saya setuju dengan <a href="#" class="text-amber-600 hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-amber-600 hover:underline">Kebijakan Privasi</a> Indonesia Luxe
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            class="w-full text-white py-3.5 rounded-xl font-semibold transition flex items-center justify-center gap-2 shadow-lg"
                            style="background: linear-gradient(135deg, #F59E0B, #D97706);"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i data-lucide="user-plus" class="w-5 h-5"></i> Buat Akun Sekarang
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative my-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-3 text-gray-400">sudah punya akun?</span>
                    </div>
                </div>

                {{-- Login Link --}}
                <div class="text-center">
                    <a href="{{ route('login') }}"
                       class="block w-full py-3 border-2 border-amber-500 text-amber-600 rounded-xl font-semibold hover:bg-amber-50 transition text-sm">
                        Masuk ke Akun
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