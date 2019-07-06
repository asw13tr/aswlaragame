<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PanelLoginControl
{
    public function handle($request, Closure $next){
        if( !Auth::check() ){
            setAlertFixed('Yönetici girişi yapılmamış.', 'danger');
            return redirect()->route('panel.login');

        }elseif( Auth::user()->level < 2 ){
            setAlertFixed('Panel görüntüleme yetkiniz bulunmamaktadır.', 'danger');
            Auth::logout();
            return redirect()->route('panel.login');

        }else{
            return $next($request);
        }
    }
}
