<?php

namespace App\Http\Middleware;

use App\Http\Traits\ResponseTrait;
use Closure;

class Premission
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        if(\Auth::user()->id == config('app.super_id')){
            return $next($request);
        }

        if(\Auth::user()->hasPermissionTo(\Route::currentRouteName(),$guard)){
            return $next($request);
        }else{
            if($request->ajax()){
                return $this->error('对不起，您无权访问！');
            }
            return abort(403,'对不起，您无权访问该页面！');
        }
    }
}
