<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\models\Liste;
use \wishlist\models\ListView;

class ListController {

    /**
     * Créé une vue affichant toutes les listes publiques
     */
    public function displayLists() : void {
        $ensemble = Liste::orderBy('expiration', 'DESC')->get();
        $v = new View(LIST_VIEW, ['title' => 'Lists' , 'list' => $ensemble]);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire de création de liste
     */
    public function displayListCreator() : void {
        $v = new View(NEW_VIEW, ['title' => 'ListCreator']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition de liste
     */
    public function displayListEditor() : void {
        // récupérer 'no' de la liste à modifier
        $list = Liste::getById($no);
        $v = new View(EDIT_VIEW, ['title' => 'ListEditor' , 'list' => $list]);
        $v->render();
    }
}


?>