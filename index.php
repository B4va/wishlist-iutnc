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
    $c = new ListController();
    $c->displayLists();
})->name('home');

/**
 * Listes
 */

// Affichage d'une liste
$app->get('/lists/:token', function($token){
    $c = new ListController();
    $c->displayObject($token);
})->name('showList');

// Affichage du formulaire de création de liste
$app->get('/lists/new', function(){
    $c = new ListController();
    $c->displayCreator();
})->name('newList');

// Création d'une liste
$app->post('/', function(){
    $c = new ListController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        $slim->request->post()['titre'],
        $slim->request->post()['description'],
        //$slim->request->post()['visibility'],
        $slim->request->post()['expiration']
    ];
    $c->create($attr);
})->name('createList');

// Affichage du formulaire d'édition de liste
$app->get('/list/edit/:token', function($token){
    $c = new ListController();
    $c->displayEditor($token);
})->name('editList');

// Mise à jour d'une liste
$app->post('/list/update/:token', function($token){
    $slim = \Slim\Slim::getInstance();
    $c = new ListController();
    $attr = [
        'titre' => $slim->request->post('titre'),
        'description' => $slim->request->post('description'),
        'expiration' => $slim->request->post('expiration')
    ];
    $c->edit($token, $attr);
    $slim->redirect('../..');
})->name('updateList');

// Suppression d'une liste
$app->get('/', function(){
    $c = new ListController();
    $slim = \Slim\Slim::getInstance();
    $token = $slim->request->get()['token'];
    $c->delete($token);
})->name('deleteList');



// ======================================================
    
// TESTS

// $app->get('/list', function(){
//     testList();
// });
// $app->get('/edit', function(){
//     testEdit();
// });
// $app->get('/new', function(){
//     testNew();
// });
// $app->get('/test', function(){
//     $ensemble = Liste::orderBy('expiration', 'DESC')->get();
//     var_dump($ensemble);
// });

// function testList(){
//     $vue = new ListView(LIST_VIEW, ['title' => 'Test listView']);
//     $vue->render();
// }

// function testEdit(){
//     $vue = new ListView(EDIT_VIEW, ['title' => 'Test editView']);
//     $vue->render();
// }

// function testNew(){
//     $vue = new ListView(NEW_VIEW, ['title' => 'Test newView']);
//     $vue->render();
// }

$app->run();

?>