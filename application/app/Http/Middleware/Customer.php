<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class Customer
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
        if(Auth::user())
        {
            if(Auth::user()->isCustomer())
            {
                if(Auth::user()->is_active)
                {
                    return $next($request);
                }
                else
                {
                    return redirect('/account-disabled');
                }
            }
            else
            {
                return redirect('/home');
            }
        }
        else
        {
            return redirect('/login');
        }
    }
}