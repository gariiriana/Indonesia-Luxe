@extends('layouts.auth')

@section('title', 'Daftar - Indonesia Luxe')

@section('content')
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-2xl font-serif font-bold">IL</span>
                </div>
                <h1 class="text-2xl font-serif text-gray-900">Buat Akun Baru</h1>
                <p class="text-gray-500 text-sm mt-1">Bergabung dengan Indonesia Luxe hari ini</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $err)
                            <li class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                                {{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Role Selector --}}
                <div x-data="{ role: '{{ old('role', 'user') }}' }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="user" x-model="role" class="sr-only">
                            <div :class="role === 'user' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-200 text-gray-600'"
                                class="border-2 rounded-xl p-3 text-center transition">
                                <i data-lucide="user" class="w-6 h-6 mx-auto mb-1"></i>
                                <p class="text-sm font-medium">Wisatawan</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="vendor" x-model="role" class="sr-only">
                            <div :class="role === 'vendor' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-200 text-gray-600'"
                                class="border-2 rounded-xl p-3 text-center transition">
                                <i data-lucide="briefcase" class="w-6 h-6 mx-auto mb-1"></i>
                                <p class="text-sm font-medium">Vendor / Operator</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Nama Anda">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="email@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required minlength="8"
                            class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Min. 8 karakter">
                        <button type="button" @click="show=!show"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i :data-lucide="show ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input type="password" name="password_confirmation" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-semibold transition shadow-md shadow-amber-200">
                    Buat Akun
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-semibold">Masuk di sini</a>
            </p>
        </div>
    </div>
@endsection