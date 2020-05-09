<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\controllers\ListController;
use wishlist\controllers\ItemController;
use wishlist\controllers\UserController;

session_start();

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
        'descr' => $slim->request->post('description'),
        'tarif' => $slim->request->post('tarif'),
        'liste_id' => $slim->request->post('liste_id')
    ];
    $c->create($attr);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('createItem');

// Affichage du formulaire d'édition d'item
$app->get('/list/:idList/item/edit/:id', function($idList, $id){
    $c = new ItemController();
    $c->displayEditor($id);
})->name('editorItem');

// Mise à jour d'un item
$app->post('/list/:idList/item/update/:id', function($idList, $id){
    $slim = \Slim\Slim::getInstance();
    $c = new ItemController();
    $attr = [
        'nom' => $slim->request->post('nom'),
        'descr' => $slim->request->post('description'),
        'tarif' => $slim->request->post('tarif')
    ];
    $c->edit($id, $attr);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('editItem');

// Suppression d'un item
$app->get('/list/:idList/item/delete/:id', function($idList, $id){
    $c = new ItemController();
    $slim = \Slim\Slim::getInstance();
    $c->delete($id);
    $back = $slim->urlFor('list', ['id' => $idList]);
    $slim->redirect($back);
})->name('deleteItem');

/**
 * Users
 */

// Affichage d'un utilisateur
$app->get('/user/:id', function($id){
    $c = new UserController();
    $c->displayObject($id);
})->name('user');

// Affichage de tous les utilisateurs
$app->get('/users', function(){
    $c = new UserController();
    $c->displayObjects();
})->name('users');

// Affichage du formulaire de création de compte utilisateur
$app->get('/users/new', function(){
    $c = new UserController();
    $c->displayCreator();
})->name('creatorUser');

// Création d'un compte utilisateur
$app->post('/user/create', function(){
    $c = new UserController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        'login' => $slim->request->post('login'),
        'password' => $slim->request->post('password'),
        'password_conf' => $slim->request->post('password_conf'),
        'lastname' => $slim->request->post('lastname'),
        'firstname' => $slim->request->post('firstname')
    ];
    $c->create($attr);
    $slim->redirect($slim->urlFor('home'));
})->name('createUser');

// Affichage du formulaire de modification d'un compte utilisateur
$app->get('/user/edit/:id', function($id){
    $c = new UserController();
    $c->displayEditor($id);
})->name('editorUser');

// Mise à jour d'un compte utilisateur
$app->post('/user/update/:id', function($id){
    $c = new UserController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        'login' => $slim->request->post('login'),
        'password' => $slim->request->post('password'),
        'password_conf' => $slim->request->post('password_conf'),
        'lastname' => $slim->request->post('lastname'),
        'firstname' => $slim->request->post('firstname')
    ];
    $c->edit($id, $attr);
    $slim->redirect($slim->urlFor('home'));
})->name('editUser');

// Suppression d'un compte utilisateur
$app->get('/user/delete/:id', function($id){
    $c = new UserController();
    $slim = \Slim\Slim::getInstance();
    $c->delete($id);
    $slim->redirect('../..');
})->name('deleteUser');

// Affichage du formulaire de connexion
$app->get('/login', function(){
    $c = new UserController();
    $c->displayLogin();
})->name('loginForm');

// Connexion utilisateur
$app->post('/login', function(){
    $c = new UserController();
    $slim = \Slim\Slim::getInstance();
    $attr = [
        'login' => $slim->request->post('login'),
        'password' => $slim->request->post('password')
    ];
    $c->loginUser($attr);
    $slim->redirect($slim->urlFor('home'));
})->name('login');

// Déconnexion utilisateur
$app->get('/logout', function(){
    $c = new UserController();
    $c->logout();
    $slim = \Slim\Slim::getInstance();
    $slim->redirect($slim->urlFor('home'));
})->name('logout');

$app->run();

?>