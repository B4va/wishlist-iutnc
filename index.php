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

// Affichage de toutes les listes publiques non expirées
$app->get('/', function(){
    ListController::displayLists();
})->name('home');

/**
 * Listes
 */

// Affichage d'une liste
$app->get('/lists', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::displayObject($token);
})->name('showList');

// Affichage du formulaire de création de liste
$app->get('/', function(){
    ListController::displayCreator();
})->name('newList');

// Création d'une liste
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

// Affichage du formulaire d'édition de liste
$app->get('list/edit', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::displayEditor($token);
})->name('editList');

// Mise à jour d'une liste
$app->put('/list/update', function(){
    $attr = [
        $slim->request->put()['titre'],
        $slim->request->put()['description'],
        //$slim->request->put()['visibility'],
        $slim->request->put()['expiration']
    ];
    ListController::update($attr);
})->name('udpateList');

// Suppression d'une liste
$app->delete('/', function(){
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    ListController::delete($token);
})->name('deleteList');



// ======================================================
    
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