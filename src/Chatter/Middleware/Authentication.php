<?php

namespace Chatter\Middleware;

use Chatter\Models\User;

class Authentication
{
    public function __invoke($request, $response, $next)
    {
        $auth = $request->getHeader('Authorization');

        $_apiKey = $auth[0];
        $apiKey = substr($_apiKey, strpos($_apiKey, ' ') + 1);
        $user = new User();
        if (!$user->authenticate($apiKey)) {
            $response->withStatus(401);
            return $response;
        }
        return $next($request, $response);
    }
}