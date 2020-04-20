<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

abstract class ListController {

    /**
     * Créé une vue affichant le formulaire de création d'un objet
     */
    abstract function displayCreator();

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     */
    abstract function displayEditor();

    /**
     * Créé une vue affichant un objet choisi par son id
     */
    abstract function displayObject($id);

    /**
     * Gère la création d'un objet
     */
    abstract function create();

    /**
     * Gère l'édition d'un objet
     */
    abstract function edit();

    /**
     * Gère la suppression d'un objet
     */
    abstract function delete();
}