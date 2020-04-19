<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\views\ListView;

$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();

$app->get('/list', function(){
    testList();
});
$app->get('/edit', function(){
    testEdit();
});
$app->get('/new', function(){
    testNew();
});

function testList(){
    $vue = new ListView(LIST_VIEW, ['title' => 'Test listView']);
    $vue->render();
}

function testEdit(){
    $vue = new ListView(EDIT_VIEW, ['title' => 'Test editView']);
    $vue->render();
}

function testNew(){
    $vue = new ListView(NEW_VIEW, ['title' => 'Test newView']);
    $vue->render();
}

$app->run();

?>