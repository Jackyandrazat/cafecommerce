<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKasirPromoAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $kasirPromoAccess = Setting::where('key', 'kasir_promo_access')->value('value') === 'true';

        if (
            auth()->user()->hasRole('kasir') &&
            (!$kasirPromoAccess || !auth()->user()->can('manage promo'))
        ) {
            abort(403, 'Akses ke fitur Promo tidak diizinkan.');
        }

        return $next($request);
    }
}
