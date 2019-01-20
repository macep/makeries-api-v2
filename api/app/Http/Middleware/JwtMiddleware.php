<?php
namespace App\Http\Middleware;

use Monolog;
use Closure;
use Exception;
use App\Token;
use App\Logging;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->headers->get('token');

        $auth = new \stdClass();
        $auth->userId = null;
        $request->auth = $auth;

        if(!$token) {
            // Unauthorized response if token not there
            $logging = new Logging();
            $logging->error($request, 'AUTH:TOKEN_MISSING');
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        /*
        $authToken = new Token();
        if (!$authToken->check($token)) {
                return response()->json([
                    'error' => 'Token invalid.'
                ], 401);
        }
        */

        try {
            $credentials = JWT::decode($token, 'JWT_SECRET', ['HS256']);
        } catch(ExpiredException $e) {
            $logging = new Logging();
            $logging->error($request, 'AUTH:TOKEN_EXPIRE', ['token'=>$token]);
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            $logging = new Logging();
            $logging->error($request, 'AUTH:TOKEN_ERROR', ['token'=>$token]);
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        //check userId
        if (!isset($credentials->userId)) {
            return response()->json([
                'error' => 'Missing userId from token.'
            ], 400);
        }
        //check userRole
        if (!isset($credentials->userRole)) {
            return response()->json([
                'error' => 'Provided token not provide user role.'
            ], 400);
        }
        //check userRole accepted list
        if (!in_array($credentials->userRole, ['superAdmin', 'groupAdmin', 'readOnlyAdmin'])) {
            return response()->json([
                'error' => 'Provided token user role unaccepted.'
            ], 400);
        }
        //if not superAdmin accessToGroup list of IDs is mandatory
        if ($credentials->userRole != 'superAdmin') {
            if (!isset($credentials->accessToGroup)) {
                return response()->json([
                    'error' => 'Missing group access list'
                ], 400);
            }
            if (is_string($credentials->accessToGroup) && !in_array($credentials->accessToGroup, ['none','all'])) {
                return response()->json([
                    'error' => 'Invalid group access value'
                ], 400);
            } elseif (is_string($credentials->accessToGroup) && 'none' == $credentials->accessToGroup) {
                return response()->json([
                    'error' => 'Access restricted'
                ], 400);
            } elseif (is_array($credentials->accessToGroup) && 0 == count($credentials->accessToGroup)) {
                return response()->json([
                    'error' => 'Invalid group access'
                ], 400);
            } elseif(!is_array($credentials->accessToGroup) && !is_string($credentials->accessToGroup)) {
                return response()->json([
                    'error' => 'Invalid group access type'
                ], 400);
            }
        }
        //readOnly users are allowed only to GET methods
        if ($credentials->userRole == 'readOnlyAdmin' && $request->getMethod() != 'GET') {
            return response()->json([
                'error' => 'Access limited to read only.'
            ], 400);
        }
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth->userId = $credentials->userId;
        $request->auth->userRole = $credentials->userRole;
        if ($credentials->userRole != 'superAdmin' && isset($credentials->accessToGroup)) {
            $request->auth->accessToGroup = $credentials->accessToGroup;
        }
        //TODO: find better way for this restriction
        /* IF not superAdmin limit access only to get for
         * product
         * region
         * business_type
         * service_type
         */
        if ($credentials->userRole != 'superAdmin') {
            $requestUri = substr($request->getRequestUri(),4);
            if ($pos = strpos($requestUri,'/')) {
                $requestUri = substr($requestUri,0,$pos);
            }
            //if ($requestUri == 'makergroup') {
            //    return response()->json('Access limited.', 400);
            //}
            if ($request->getMethod() != 'GET'
                && in_array($requestUri,['businesstype','product','region','servicetype'])
                ) {
                return response()->json('Access limited.', 400);
            }
        }
        return $next($request);
    }
}