<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

abstract class Controller {

    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un objet
     */
    abstract protected function displayCreator() : void;

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     */
    abstract protected function displayEditor($id) : void;

    /**
     * Créé une vue affichant un objet choisi par son id
     * @param [$id] identifiant de l'objet
     */
    abstract protected function displayObject($id) : void;

    /* 
             _________________________
            |                         |
            |    Gestion de la bdd    |
            |_________________________|              
    */

    /**
     * Gère la création d'un objet
     */
    abstract protected function create($attr) : void;

    /**
     * Gère l'édition d'un objet
     */
    abstract protected function edit($id, $attr);

    /**
     * Gère la suppression d'un objet
     */
    abstract protected function delete($id);
}