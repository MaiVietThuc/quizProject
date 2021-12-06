<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class student
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
        if(Auth::guard('student')->check())
        {
            $admin = Auth::guard('student')->user();
            if($admin->status == 1){
                return $next($request);
            }else{
                return Redirect::back()->with('error', 'Lỗi tài khoản!! Tài khoản đã bị vô hiệu hóa!'); 
            }
        }else{
            return redirect('/studentLogin')->with('error','Chưa đăng nhập!!');
        }
    }
}
