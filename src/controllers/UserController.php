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
    public function displayEditor($token) : void {
        $user = User::getByToken($token);
        $v = new UserView(EDIT_VIEW, ['title' => 'Edition de l\'user' . $user->login, 'object' => $user]);
        $v->render();
    }

    /**
     * Créé une vue affichant un user choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
        $user = User::getById($id);
        $v = new UserView(OBJECT_VIEW, ['title' => 'User ' . $user->login, 'object' => $user]);
        $v->render();
    }

    /**
     * Créé une vue affichant tous les users
     */
    public function displayObjects() : void {
        $ensemble = User::getAll();
        $v = new UserView(OBJECTS_VIEW, ['title' => 'Users', 'objects' => $ensemble]);
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
    public function edit($token, $newAttr){
        User::getByToken($token)->edit($newAttr);
    }

    /**
     * Gère la suppression d'un user
     */
    public function delete($token) : void {
        User::getByToken($token)->delete();
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

}


?>