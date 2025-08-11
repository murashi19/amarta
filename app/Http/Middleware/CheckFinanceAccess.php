<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckFinanceAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Cek hak akses keuangan
        if (!$user->canAccessFinancePage()) {
            $errorMessage = $user->getFinanceAccessErrorMessage();
            
            return redirect()->route('dashboard.users')
                ->with('error', $errorMessage);
        }

        return $next($request);
    }
}
