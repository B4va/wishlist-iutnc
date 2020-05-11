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
    $listController = new ListController();
    $listController->displayObjects();
})->name('home');

/**
 * Listes
 */

// Affichage d'une liste
$app->get('/list/:id', function($id){
    $listController = new ListController();
    $listController->displayObject($id);
})->name('list');

// Affichage du formulaire de création de liste
$app->get('/lists/new', function(){
    $listController = new ListController();
    $listController->displayCreator();
})->name('creatorList');

// Création d'une liste
$app->post('/list/create', function(){
    $listController = new ListController();
    $listController->create();
})->name('createList');

// Affichage du formulaire d'édition de liste
$app->get('/list/edit/:token', function($token){
    $listController = new ListController();
    $listController->displayEditor($token);
})->name('editorList');

// Mise à jour d'une liste
$app->post('/list/update/:token', function($token){
    $listController = new ListController();
    $listController->edit($token);
})->name('editList');

// Suppression d'une liste
$app->get('/list/delete/:token', function($token){
    $listController = new ListController();
    $listController->delete($token);
})->name('deleteList');

/**
 * Items
 */

// Affichage du formulaire de création d'item
$app->get('/list/:idList/item/new', function($idList){
    $itemController = new ItemController();
    $itemController->displayCreator($idList);
})->name('creatorItem');

// Création d'un item
$app->post('/list/item/create', function(){
    $itemController = new ItemController();
    $itemController->create();
})->name('createItem');

// Affichage du formulaire d'édition d'item
$app->get('/list/item/edit/:id', function($id){
    $itemController = new ItemController();
    $itemController->displayEditor($id);
})->name('editorItem');

// Mise à jour d'un item
$app->post('/list/item/update/:id', function($id){
    $itemController = new ItemController();
    $itemController->edit($id);
})->name('editItem');

// Suppression d'un item
$app->get('/list/item/delete/:id', function($id){
    $itemController = new ItemController();
    $itemController->delete($id);
})->name('deleteItem');

// Réservation d'un item
$app->get('/list/item/reserve/:id', function($id){
    $itemController = new ItemController();
    $itemController->reserve($id);
})->name('reserveItem');

/**
 * Users
 */

// Affichage d'un utilisateur
$app->get('/user/:id', function($id){
    $userController = new UserController();
    $userController->displayObject($id);
})->name('user');

// Affichage de tous les utilisateurs
$app->get('/users', function(){
    $userController = new UserController();
    $userController->displayObjects();
})->name('users');

// Affichage du formulaire de création de compte utilisateur
$app->get('/users/new', function(){
    $userController = new UserController();
    $userController->displayCreator();
})->name('creatorUser');

// Création d'un compte utilisateur
$app->post('/user/create', function(){
    $userController = new UserController();
    $userController->create();
})->name('createUser');

// Affichage du formulaire de modification d'un compte utilisateur
$app->get('/user/edit/:id', function($id){
    $userController = new UserController();
    $userController->displayEditor($id);
})->name('editorUser');

// Mise à jour d'un compte utilisateur
$app->post('/user/update/:id', function($id){
    $userController = new UserController();
    $userController->edit($id);
})->name('editUser');

// Suppression d'un compte utilisateur
$app->get('/user/delete/:id', function($id){
    $userController = new UserController();
    $userController->delete($id);
    $userController->logout();
})->name('deleteUser');

// Affichage du formulaire de connexion
$app->get('/login', function(){
    $userController = new UserController();
    $userController->displayLogin();
})->name('loginForm');

// Connexion utilisateur
$app->post('/login', function(){
    $userController = new UserController();
    $userController->loginUser();
})->name('login');

// Déconnexion utilisateur
$app->get('/logout', function(){
    $userController = new UserController();
    $userController->logout();
})->name('logout');

$app->run();

?>