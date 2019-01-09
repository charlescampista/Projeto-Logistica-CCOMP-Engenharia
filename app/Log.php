<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogLevel {
    public static $LOG_LEVEL_ERROR = "error";
    public static $LOG_LEVEL_INFO = "info";
}

class Log extends Model
{
    protected $table = "log";
    
    public static function make($logLevel, $msg) {
        $log = new Log();
        $log['msg'] = $msg;
        $log['type'] = $logLevel;
        $log->save();
    }
}
