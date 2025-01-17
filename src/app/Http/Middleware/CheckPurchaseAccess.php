<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPurchaseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('purchase_from_detail')) {
            $request->session()->forget('purchase_from_detail');
            return $next($request);
        }

        return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
    }
}
