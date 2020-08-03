<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(!Auth::check()){
        return redirect()->route('admin.login');
        // admin girişi yoksa bizi çıkışa yönlendirsin diye
        // tanımlı olması için kernel de tanımla   protected $routeMiddleware
      }
        return $next($request);
    }
}
