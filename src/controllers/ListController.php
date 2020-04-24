<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Liste;
use \wishlist\views\ListView;

class ListController implements Controller {

    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'une liste
     */
    public function displayCreator() : void {
        $v = new ListView(CREATE_VIEW, ['title' => 'Nouvelle liste']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'une liste
     */
    public function displayEditor($token) : void {
        $list = Liste::getByToken($token);
        $v = new ListView(EDIT_VIEW, ['title' => 'Edition de liste ' . $list->nom, 'object' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant une liste choisie par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
        $list = Liste::getById($id);
        $v = new ListView(OBJECT_VIEW, ['title' => 'Edition de liste ' . $list->nom, 'object' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant toutes les listes publiques
     */
    public function displayObjects() : void {
        $ensemble = Liste::getLists();
        $v = new ListView(OBJECTS_VIEW, ['title' => 'Lists', 'objects' => $ensemble]);
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
        Liste::create($attr);
    }

    /**
     * Gère l'édition d'une liste
     */
    public function edit($token, $newAttr){
        Liste::getByToken($token)->edit($newAttr);
    }

    /**
     * Gère la suppression d'une liste
     */
    public function delete($token) : void {
        Liste::getByToken($token)->delete();
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

}


?>