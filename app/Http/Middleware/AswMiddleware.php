<?php

namespace App\Http\Middleware;

use Closure;
use App\Config;

class AswMiddleware{
    public function handle($request, Closure $next){
        
        return $next($request);
    }
}
