<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\views\ListView;

$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();

$app->get('/', function(){
    test();
});

function test(){
    $vue = new ListView(PUBLIC_LISTS_VIEW, ['title' => 'test view']);
    $vue->render();
}

$app->run();

?>