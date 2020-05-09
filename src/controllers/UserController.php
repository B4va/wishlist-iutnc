<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\User;
use \wishlist\views\UserView;

class UserController extends Controller {


    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un user
     */
    public function displayCreator($id = null) : void {
        $v = new UserView(CREATE_VIEW, ['title' => 'Nouvel user']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un user
     */
    public function displayEditor($id) : void {
        $this->authRequired();
        $this->propRequired($id);
        $user = User::getById($id);
        $v = new UserView(EDIT_VIEW, ['title' => 'Edition de l\'user' . $user->login, 'object' => $user]);
        $v->render();
    }

    /**
     * Créé une vue affichant un user choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
        $user = User::getById($id);
        $lists = $user->getLists();
        $v = new UserView(OBJECT_VIEW, ['title' => 'Utilisateur ' . $user->login, 'object' => $user, 'lists' => $lists]);
        $v->render();
    }

    /**
     * Créé une vue affichant tous les users
     */
    public function displayObjects() : void {
        $ensemble = User::getAll();
        $v = new UserView(OBJECTS_VIEW, ['title' => 'Utilisateurs', 'objects' => $ensemble]);
        $v->render();
    }

    /* 
             _________________________
            |                         |
            |    Gestion de la bdd    |
            |_________________________|              
    */

    /**
     * Gère la création d'un user
     */
    public function create($attr) : void {
        $slim = \Slim\Slim::getInstance();
        if ($attr['password'] != $attr['password_conf']) {
            $slim->flash('warning', 'Les mots de passes saisis sont différents');
            $slim->redirect($slim->urlFor('creatorUser'));
        } else if (User::getByLogin($attr['login']) !== null) {
            $slim->flash('warning', 'Le login saisi est déja utilisé');
            $slim->redirect($slim->urlFor('creatorUser'));
        } else {
            unset($attr['password_conf']);
            User::create($attr);
            $slim->redirect($slim->urlFor('home'));
        }
    }

    /**
     * Gère l'édition d'un user
     */
    public function edit($id, $newAttr){
        $this->authRequired();
        $this->propRequired($id);
        User::getById($id)->edit($newAttr);
        if (isset($_COOKIE['user'])) setcookie('user', null, -1);
        setcookie('user', serialize(User::getById($id)), time()+60*60*24*30);
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('home'));
    }

    /**
     * Gère la suppression d'un user
     */
    public function delete($id) : void {
        $this->authRequired();
        $this->propRequired($id);
        User::getById($id)->delete();
        if (isset($_COOKIE['user'])) setcookie('user', null, -1);
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

    /**
     * Créé une vue d'authentification
     */
    public function displayLogin(){
        $v = new UserView(AUTHENTICATE_VIEW, ['title' => 'Auhtentification']);
        $v->render();
    }

    /**
     * Gère l'authentification
     */
    public function loginUser($form){
        $slim = \Slim\Slim::getInstance();
        if(User::loginUser($form)){
            $slim->flash('success', 'Vous êtes à présent connecté' );
            setcookie('user', serialize(User::getByLogin($form['login'])), time()+60*60*24*30);
            $slim->redirect($slim->urlFor('home'));
        } else {
            $slim->flash('danger', 'Les informations de connexion sont erronées' );
            $slim->redirect($slim->urlFor('loginForm'));
        }
    }

    /**
     * Gère la déconnexion
     */
    public function logout(){
        $this->authRequired();
        if (isset($_COOKIE['user'])) setcookie('user', null, -1);
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('home'));
    }

}


?>