<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\ControllerOperations;
use \wishlist\models\Item;
use \wishlist\views\ItemView;

class ItemController implements ControllerOperations {


    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un item
     */
    public function displayCreator() : void {
        $v = new ItemView(CREATE_VIEW, ['title' => 'Nouvel item']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un item
     */
    public function displayEditor($token) : void {
        $item = Item::getByToken($token);
        $v = new ItemView(EDIT_VIEW, ['title' => 'Edition de l\'item' . $item->nom, 'object' => $item]);
        $v->render();
    }

    /**
     * Créé une vue affichant un item choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
        $item = Item::getById($id);
        $v = new ItemView(OBJECT_VIEW, ['title' => 'Item ' . $item->nom, 'object' => $item]);
        $v->render();
    }

    /**
     * Créé une vue affichant tous les items
     */
    public function displayObjects() : void {
        $ensemble = Item::getAll();
        $v = new ItemView(OBJECTS_VIEW, ['title' => 'Items', 'objects' => $ensemble]);
        $v->render();
    }

    /* 
             _________________________
            |                         |
            |    Gestion de la bdd    |
            |_________________________|              
    */

    /**
     * Gère la création d'un item
     */
    public function create($attr) : void {
        Item::create($attr);
    }

    /**
     * Gère l'édition d'un item
     */
    public function edit($token, $newAttr){
        Item::getByToken($token)->edit($newAttr);
    }

    /**
     * Gère la suppression d'un item
     */
    public function delete($token) : void {
        Item::getByToken($token)->delete();
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

}


?>