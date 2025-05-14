<?php

namespace Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class API extends Controller
{
    public function baererToken(Request $request): string
    {
        $token = $request->bearerToken() ;
        if($token==NULL || strlen($token) == 0)
        {
            abort(401);
        }
        else return  $token;
    }
}
