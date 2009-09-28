<?php

class Config {

    private static $conf;
    
    public function __construct($inputfile = 'config.php') {
        self::setupConf($inputfile); 
    }
    public static function getConf() {
        if(!isset(self::$conf)){
            self::setupConf('config.php');
        }
        return self::$conf;
    }


    private static function setupConf($file) {
        require_once($file);
        self::$conf = $conf;
    }


}
