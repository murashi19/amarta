<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnsTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $transaction = $request->route('transaction'); // sudah jadi model langsung

        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke transaksi ini.');
        }

        return $next($request);
    }

}
