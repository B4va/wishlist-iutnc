<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Liste;
use \wishlist\models\ListView;

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
    protected function displayCreator() : void {
        $v = new View(NEW_VIEW, ['title' => 'ListCreator']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'une liste
     */
    protected function displayEditor() : void {
        // récupérer 'no' de la liste à modifier
        $list = Liste::getById($no);
        $v = new View(EDIT_VIEW, ['title' => 'ListEditor' , 'list' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant une liste choisie par son id
     * @param [$id] identifiant de l'objet
     */
    protected function displayObject($id) : void {
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
    protected function create() : void {

    }

    /**
     * Gère l'édition d'une liste
     */
    protected function edit(){

    }

    /**
     * Gère la suppression d'une liste
     */
    protected function delete(){

    }

    /*
         _____________________________________
        |                                     |
        |   Fonctionnalités supplémentaires   |
        |_____________________________________|
    */

    /**
     * Créé une vue affichant toutes les listes publiques
     */
    public function displayLists() : void {
        $ensemble = Liste::orderBy('expiration', 'DESC')->get();
        $v = new View(LIST_VIEW, ['title' => 'Lists' , 'list' => $ensemble]);
        $v->render();
    }
}


?>