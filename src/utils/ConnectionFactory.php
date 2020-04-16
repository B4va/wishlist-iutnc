<?php

namespace wishlist\utils;
require_once './vendor/autoload.php';
use \Illuminate\Database\Capsule\Manager as DB;
use PDO;

class ConnectionFactory {

    private static $config = null;
    private static $db = null;

    public static function makeConnection() {
        $db = new DB();
        $db->addConnection(parse_ini_file('src/conf/conf.ini'));
        $db->setAsGlobal();
        $db->bootEloquent();
        return self::$db;
  }
}

?>