<?php

require_once 'vendor/autoload.php';
use \wishlist\conf\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();



$app->run();

?>