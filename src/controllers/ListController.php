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
    public function displayCreator() : void {
        $v = new ListView(NEW_VIEW, ['title' => 'ListCreator']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'une liste
     */
    public function displayEditor($token) : void {
        $list = Liste::getByToken($token);
        $v = new ListView(EDIT_VIEW, ['title' => 'Editer la liste ' . $list->nom, 'list' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant une liste choisie par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void {
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
        Liste::getByToken($token)->delete($token);
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
        $ensemble = Liste::getLists();
        $v = new ListView(LIST_VIEW, ['title' => 'Lists', 'list' => $ensemble]);
        $v->render();
    }
}


?>