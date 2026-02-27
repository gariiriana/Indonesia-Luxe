<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (!$user->isVendor() && !$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda harus menjadi vendor untuk mengakses halaman ini.');
        }

        if ($user->isVendor() && (!$user->vendor || !$user->vendor->isApproved())) {
            return redirect()->route('home')->with('error', 'Akun vendor Anda belum disetujui.');
        }

        return $next($request);
    }
}
