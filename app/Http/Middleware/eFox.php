<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;

class eFox
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
        if ( $this->checkToken( $request ) ) {
            return $next( $request );
        }

        return response()->json( [ 'error' => 'Unauthorized' ], 403 );
    }

    function checkToken( $request ) {

        $client = $request->header( 'client' );
        $token  = $request->header( 'token' );

        $checkToken = ApiToken::where( 'client', $client )
                              ->where( 'token', $token )->first();

        return $checkToken;
    }
}
