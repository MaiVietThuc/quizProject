<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use Redirect;

class admin
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
        if(Auth::guard('admin')->check())
        {
            $admin = Auth::guard('admin')->user();
            if($admin->status == 1){
                return $next($request);
            }else{
                return Redirect::back()->with('error', 'Lỗi tài khoản!! Tài khoản đã bị vô hiệu hóa!'); 
            }
        }else{
            return redirect('/adminlogin')->with('error','Chưa đăng nhập!!');
        }
    }
}
