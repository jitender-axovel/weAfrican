<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;
use App;
use Auth;
use App\CmsPage;

class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $cmsPages = CmsPage::get();
        view()->share('cmsPages', $cmsPages);
        view()->share('ip', $ip);
        return $next($request);
    }
}