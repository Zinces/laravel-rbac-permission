<?php

namespace App\Http\Middleware;

use App\Library\ErrorCode;
use Closure;

class CanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!can()) {
            if ($request->ajax()) {
                return response(['code' => ErrorCode::FORBIDDEN, 'msg' => '您没有被授权访问', 'data' => []]);
            }
            return redirect(route('admin.forbidden.white'));
        }

        return $next($request);
    }
}
