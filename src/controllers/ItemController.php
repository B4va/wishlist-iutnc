<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Item;
use \wishlist\views\ItemView;

class ItemController extends Controller {


    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un item
     */
    public function displayCreator($idList = null) : void {
        $this->authRequired();
        $v = new ItemView(CREATE_VIEW, ['title' => 'Nouvel item', 'idList' => $idList]);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un item
     */
    public function displayEditor($id) : void {
        $this->authRequired();
        $this->propRequired($id);
        $item = Item::getById($id);
        $v = new ItemView(EDIT_VIEW, ['title' => 'Edition de l\'item' . $item->nom, 'object' => $item]);
        $v->render();
    }

    /**
     * Créé une vue affichant un item choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {}

    /**
     * Créé une vue affichant tous les items
     */
    public function displayObjects() : void {}

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
        $this->authRequired();
        Item::create($attr);
    }

    /**
     * Gère l'édition d'un item
     */
    public function edit($id, $newAttr){
        $this->authRequired();
        $this->propRequired($id);
        Item::getById($id)->edit($newAttr);
    }

    /**
     * Gère la suppression d'un item
     */
    public function delete($id) : void {
        $this->authRequired();
        $this->propRequired($id);
        Item::getById($id)->delete();
    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

}


?>