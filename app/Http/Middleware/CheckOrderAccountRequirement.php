<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderAccountRequirement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requireAccount = Setting::get('require_account_for_order', '1') === 'true';

        if ($requireAccount && !auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memesan.');
        }

        return $next($request);
    }
}
