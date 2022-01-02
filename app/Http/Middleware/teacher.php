<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class teacher
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
        if(Auth::guard('teacher')->check())
        {
            $teacher = Auth::guard('teacher')->user();
            if($teacher->status == 1){
                return $next($request);
            }else{
                Auth::guard('teacher')->logout();
                return redirect('/teacherLogin')->with('error', 'Lỗi tài khoản!! Tài khoản đã bị vô hiệu hóa!'); 
            }
        }else{
            return redirect('/teacherLogin')->with('error','Chưa đăng nhập!!');
        }
    }
}
