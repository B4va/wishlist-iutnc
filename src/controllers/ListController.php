<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\models\Liste;
use \wishlist\models\ListView;

class ListController {

    /**
     * Créé une vue affichant toutes les listes publiques
     */
    public function displayLists() {
        $ensemble = Liste::orderBy('expiration', 'DESC')->get();
        $v = new View(LIST_VIEW, ['title' => 'displayLists' , 'list' => $ensemble]);
        $v->render();
    }
}


?>