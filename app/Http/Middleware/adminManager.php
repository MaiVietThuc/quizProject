<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App;
use Session;
use Redirect;

class adminManager
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
            $adminManager = Auth::guard('admin')->user();
            if($adminManager->admin_role->role_name == 'Admin_manager' && $adminManager->status == 1){
                return $next($request);
            }else{
                return Redirect::back()->with('error', 'Bạn không đủ quyền sử dụng tính năng này!!'); 
            }
        }else{
            return redirect('/adminlogin')->with('message','Chưa đăng nhập!!');
        }
        
    }
}
