<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Liste;
use \wishlist\views\ListView;

class ListController extends Controller {

    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'une liste
     */
    public function displayCreator($idList = null) : void {
        $this->authRequired();
        $v = new ListView(CREATE_VIEW, ['title' => 'Nouvelle liste']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'une liste
     */
    public function displayEditor($token) : void {
        $this->authRequired();
        $list = Liste::getByToken($token);
        $this->propRequired($list->user_id);
        $v = new ListView(EDIT_VIEW, ['title' => 'Edition de liste ' . $list->nom, 'object' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant une liste choisie par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
        $list = Liste::getById($id);
        $items = $list->getItems();
        $v = new ListView(OBJECT_VIEW, ['title' => 'Liste ' . $list->nom, 'object' => $list, 'items' => $items]);
        $v->render();
    }

    /**
     * Créé une vue affichant toutes les listes
     */
    public function displayObjects() : void {
        $ensemble = Liste::getAll();
        $v = new ListView(OBJECTS_VIEW, ['title' => 'Listes', 'objects' => $ensemble]);
        $v->render();
    }

    /* 
             _________________________
            |                         |
            |    Gestion de la bdd    |
            |_________________________|              
    */

    /**
     * Gère la création d'une liste
     */
    public function create($attr) : void {
        $this->authRequired();
        Liste::create($attr);
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('home'));
    }

    /**
     * Gère l'édition d'une liste
     */
    public function edit($token, $newAttr){
        $this->authRequired();
        $l = Liste::getByToken($token);
        $this->propRequired($l->user_id);
        $l->edit($newAttr);
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('list', ['id' => $l->no]));
    }

    /**
     * Gère la suppression d'une liste
     */
    public function delete($token) : void {
        $this->authRequired();
        $l = Liste::getByToken($token);
        $this->propRequired($l->user_id);
        $l->delete();
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('home'));
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

}


?>