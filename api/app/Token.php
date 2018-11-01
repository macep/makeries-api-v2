<?php

namespace App;
use App\User;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Token extends Model 
{
    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt($accountApi) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $accountApi->account_id, // Subject of the token
            'settings' => $accountApi->settings, // Account settings
            'email' => $accountApi->email, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60*24*365 // Expiration time
        ];
        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        //return JWT::encode($payload, env('JWT_SECRET'));
        return JWT::encode($payload, 'JWT_SECRET');
    }

    function login($email, $password) {
        $user = User::where('email', $email)
                        ->where('password', md5($password))
                        ->where('role', 'admin')
                        ->first();
        return $user;
    }
    
    function authentificate($email, $password) {
        $accountApi = $this->login($email, $password);
        if ($accountApi) {
            
            $token = $this->jwt($accountApi);
            $accountApi->token = $token;
            $accountApi->save();

            return $token;
        }
        return null;
    }

    function check($token) {
        $accountApi = AccountApi::where('token', $token)
                                    ->first();
        if ($accountApi) {
            return true;
        }
        return false;
    }

}
