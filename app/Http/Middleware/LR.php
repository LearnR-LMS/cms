<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;

class LR
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
        if ($this->checkToken($request)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    function checkToken($request)
    {

        $client = $request->header('client');
        $client = $request->header('client');
        if ($client != 'lr') return false;

        $token  = $request->header('token');

        $checkToken = ApiToken::where('client', $client)
            ->where('token', $token)->first();

        return $checkToken;
    }
}
