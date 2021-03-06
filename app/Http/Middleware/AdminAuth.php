<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Model\Permissions;


class AdminAuth
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
        //判断用户是否登录
        $session = $request->session('user.id');
        // dd($session);
        if(!$session->has('user')){
            //如果用户未登录，调到登录页
            return redirect('/admin/login')->send();
        }
        
        //完成视图共享
        View::share('username',$session->get('user.username'));
        View::share('user_pic',$session->get('user.image_url'));
        
        //左侧菜单视图共享
        View::share('menus',Permissions::getMeuns());

        return $next($request);
    }
}
