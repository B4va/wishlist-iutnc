<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\ControllerOperations;
use \wishlist\models\User;
use \wishlist\views\UserView;

class UserController implements ControllerOperations {


    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un user
     */
    public function displayCreator() : void {
        $v = new UserView(CREATE_VIEW, ['title' => 'Nouvel user']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un user
     */
    public function displayEditor($id) : void {
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
        User::create($attr);
    }

    /**
     * Gère l'édition d'un user
     */
    public function edit($id, $newAttr){
        User::getById($id)->edit($newAttr);
    }

    /**
     * Gère la suppression d'un user
     */
    public function delete($id) : void {
        User::getById($id)->delete();
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

    public function displayLogin(){
        $v = new UserView(AUTHENTICATE_VIEW, ['title' => 'Auhtentification']);
        $v->render();
    }

}


?>