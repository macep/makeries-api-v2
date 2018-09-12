<?php

namespace App;

use Monolog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Logging extends Model 
{
    function getLog($file='logging') {
        $log = new Monolog\Logger(__METHOD__);
        $log->pushHandler(new Monolog\Handler\StreamHandler(storage_path().'/logs/'.$file.'.log'));
        return $log;
    }

    function info($request, $title, $data = [], $file='request') {
        $this->getLog($file)->addInfo($request->ip() . ' ' . $request->auth->userId . ' ' . $title, $data);
    }

    function error($request, $title, $data = [], $file='request') {
        $this->getLog($file)->addError($request->ip(). ' ' . ($request->auth ? $request->auth->userId : '--') . ' ' . $title, $data);
    }

    function warning($request, $title, $data = [], $source=null, $file='request') {
        $this->getLog($file)->addWarning($request->ip(). ' ' . $request->auth->userId . ' ' . $title, $data);
    }
}