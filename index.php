<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\controllers\ListController;

$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();


/**
 * Général
 */
$app->get('/', function(){
    ListController::displayLists();
})->name('home');

/**
 * Listes
 */
$app->get('/lists', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::displayObject($token);
})->name('/list/new');
$app->get('/', function(){
    ListController::displayCreator();
})->name('newList');
$app->post('/', function(){
    $slim = \Slim\Slim::getInstance();
    $attr = [
        $slim->request->post()['titre'],
        $slim->request->post()['description'],
        //$slim->request->post()['visibility'],
        $slim->request->post()['expiration']
    ];
    ListController::create($attr);
})->name('createList');
$app->get('list/edit', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::displayEditor($token);
})->name('editList');
$app->put('/list/update', function(){
    $attr = [
        $slim->request->put()['titre'],
        $slim->request->put()['description'],
        //$slim->request->put()['visibility'],
        $slim->request->put()['expiration']
    ];
    ListController::update($attr);
})->name('udpateList');
$app->get('/', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::delete($token);
})->name('deleteList');
    
// TESTS

$app->get('/list', function(){
    testList();
});
$app->get('/edit', function(){
    testEdit();
});
$app->get('/new', function(){
    testNew();
});
$app->get('/test', function(){
    $ensemble = Liste::orderBy('expiration', 'DESC')->get();
    var_dump($ensemble);
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