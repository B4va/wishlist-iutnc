<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\controllers\ListController;
use wishlist\controllers\ItemController;
use wishlist\controllers\UserController;


$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();

/**
 * Général
 */

// Affichage de toutes les listes publiques non expirées
$app->get('/', function(){
    $c = new ListController();
    $c->displayObjects();
})->name('home');

/**
 * Listes
 */

// Affichage d'une liste
$app->get('/list/:id', function($id){
    $c = new ListController();
    $c->displayObject($id);
})->name('list');

// Affichage du formulaire de création de liste
$app->get('/lists/new', function(){
    $c = new ListController();
    $c->displayCreator();
})->name('creatorList');

// Création d'une liste
$app->post('/list/create', function(){
    $c = new ListController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        'titre' => $slim->request->post('titre'),
        'description' => $slim->request->post('description'),
        'expiration' => $slim->request->post('expiration')
    ];
    $c->create($attr);
    $slim->redirect('..');
})->name('createList');

// Affichage du formulaire d'édition de liste
$app->get('/list/edit/:token', function($token){
    $c = new ListController();
    $c->displayEditor($token);
})->name('editorList');

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
})->name('editList');

// Suppression d'une liste
$app->get('/list/delete/:token', function($token){
    $c = new ListController();
    $slim = \Slim\Slim::getInstance();
    $c->delete($token);
    $slim->redirect('../..');
})->name('deleteList');

/**
 * Items
 */

// Affichage du formulaire de création d'item
$app->get('/list/:idList/item/new', function($idList){
    $c = new ItemController();
    $c->displayCreator($idList);
})->name('creatorItem');

// Création d'un item
$app->post('/list/:idList/item/create', function($idList){
    $c = new ItemController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        'nom' => $slim->request->post('nom'),
        'description' => $slim->request->post('description'),
        'tarif' => $slim->request->post('tarif')
    ];
    $c->create($attr, $idList);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('createItem');

// Affichage du formulaire d'édition d'item
$app->get('/list/:idList/item/edit/:id', function($id){
    $c = new ItemController();
    $c->displayEditor($id);
})->name('editorItem');

// Mise à jour d'un item
$app->post('/list/:token/item/update/:id', function($id, $idList){
    $slim = \Slim\Slim::getInstance();
    $c = new ItemController();
    $attr = [
        'nom' => $slim->request->post('nom'),
        'description' => $slim->request->post('description'),
        'tarif' => $slim->request->post('tarif')
    ];
    $c->edit($id, $attr);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('editItem');

// Suppression d'un item
$app->get('/list/:token/item/delete/:id', function($id, $idList){
    $c = new ItemController();
    $slim = \Slim\Slim::getInstance();
    $c->delete($id);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('deleteItem');

$app->run();

?>