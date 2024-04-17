<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\UserRole;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $su = UserRole::where([
            'name' => 'Super Admin'
        ])->first();

        if (Auth::user()->role != $su->id) {

            return redirect()->route('home')->with(['message' => ['Akses Ditolak', 'danger']]);;
        }

        return $next($request);
    }
}
