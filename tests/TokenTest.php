<?php
namespace Tests;

use Firebase\JWT\JWT;

class ProductTest extends TestCase
{
    private $tokenExpired = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImp0aSI6ImUzMGUyMWJkLWRkZjItNGQ1MC05OTdiLTEyMWU0YzJlYjJhOCIsImlhdCI6MTUzNjY4OTQyMSwiZXhwIjoxNTM2NjkzMjM1LCJ1c2VySWQiOiIxMiIsInVzZXJSb2xlIjoic3VwZXJBZG1pbiJ9.yRoRXVpz0askgn4C2iQ8te1rE5TrRELD0p8k50096zg';
    
    public function getCalls() {
        $actions = [
                    'maker'=>['GET','POST'],
                    'maker/1'=>['GET','PUT','DELETE'],
                    'maker/1/image'=>['GET','POST'],
                    'maker/1/image/1'=>['GET','DELETE'],

                    'region'=>['GET','POST'],
                    'region/1'=>['GET','PUT','DELETE'],

                    'businesstype'=>['GET','POST'],
                    'businesstype/1'=>['GET','PUT','DELETE'],

                    'servicetype'=>['GET','POST'],
                    'servicetype/1'=>['GET','PUT','DELETE'],

                    'product'=>['GET','POST'],
                    'product/1'=>['GET','PUT','DELETE'],

                    'project'=>['GET','POST'],
                    'project/1'=>['GET','PUT','DELETE'],
                    'project/1/image'=>['GET','POST'],
                    'project/1/image/1'=>['GET','DELETE'],

                    'media'=>['GET','POST'],
                    'media/1'=>['GET','PUT','DELETE'],

                    'makergroup'=>['GET','POST'],
                    'makergroup/1'=>['GET','PUT','DELETE'],
                    ];
        return $actions;
    }

    public function testTokenMissing(){
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $operation = strtolower($method);
                $this->$operation('/v2/'.$call);
                $this->seeStatusCode(401);
            }
        }
    }

    public function testTokenInvalid(){
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> 'some garbage data'];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
        
    public function testTokenExpired(){
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $this->tokenExpired];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
    
    public function testTokenMissingUserId(){
        $token = $this->generateTokenMissingUserId();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
    
    public function testTokenMissingUserRole(){
        $token = $this->generateTokenMissingUserRole();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
    
    public function testTokenWrongUserRole(){
        $token = $this->generateTokenWrongUserRole();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
    
    public function testTokenGroupAdminMissingAccessToGroup(){
        $token = $this->generateTokenGroupAdminMissingAccessToGroup();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }

    public function testTokenReadOnlyAdminMissingAccessToGroup(){
        $token = $this->generateTokenReadOnlyAdminMissingAccessToGroup();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' == $method) {
                    $this->$operation('/v2/'.$call, $headers);
                } else {
                    $this->$operation('/v2/'.$call, [], $headers);
                }
                $this->seeStatusCode(400);
            }
        }
    }
    
    /*
     * readOnlyAdmin are limitted to GET only.
     * 
     * will test if all other type of requestmethod
     * are limited
     */
    public function testTokenReadOnlyAdminLimitedToGet(){
        $token = $this->generateTokenReadOnlyAdminValid();
        $calls = $this->getCalls();
        foreach ($calls as $call=>$methods) {
            foreach ($methods as $method) {
                $headers = ['token'=> $token];
                $operation = strtolower($method);
                if ('GET' != $method) {
                    $this->$operation('/v2/'.$call, [], $headers);
                    $this->seeStatusCode(400);
                }
            }
        }
    }

    /*
     * TODO: test if accessToGroup is one of:
     * [NR1, NR2, ...]
     * 'all'
     * 'none'
     */

    private function generateTokenMissingUserId() {
        return $this->generateToken();
    }
    
    private function generateTokenMissingUserRole() {
        return $this->generateToken(['userId'=>1]);
    }
    
    private function generateTokenWrongUserRole() {
        return $this->generateToken(['userId'=>1,'userRole'=>'garbage']);
    }

    private function generateTokenGroupAdminMissingAccessToGroup() {
        return $this->generateToken(['userId'=>1,'userRole'=>'groupAdmin']);
    }

    private function generateTokenReadOnlyAdminMissingAccessToGroup() {
        return $this->generateToken(['userId'=>1,'userRole'=>'readOnlyAdmin']);
    }

    private function generateTokenReadOnlyAdminValid() {
        return $this->generateToken(['userId'=>1,'userRole'=>'readOnlyAdmin','accessToGroup'=>[1,2,3]]);
    }

    /*
     * $data will fill token payload with more info
     *  - userId : INTEGER
     *  - userRole : ['superAdmin', 'groupAdmin', 'readOnlyAdmin']
     *  - accessToGroup : [NR1, NR2, ...] || 'all' || 'none'
     */
    private function generateToken($data = []) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60*24*365 // Expiration time
        ];
        foreach ($data as $key=>$value) {
            $payload[$key] = $value;
        }
        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        //return JWT::encode($payload, env('JWT_SECRET'));
        return JWT::encode($payload, 'JWT_SECRET');
    }

}