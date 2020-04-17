<?php

namespace wishlist\utils;

require_once './vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as DB;
use PDO;

/**
 * Classe utilitaire : connexion à la bdd
 */
class ConnectionFactory {

    private static $config = null;
    private static $db = null;

    /**
     * Etablit la connexion grâce aux paramètres du fichier conf.ini
     * @static
     */
    public static function makeConnection() {
        $db = new DB();
        $db->addConnection(parse_ini_file('src/conf/conf.ini'));
        $db->setAsGlobal();
        $db->bootEloquent();
        return self::$db;
  }
}

?>