<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

interface Controller {

    /* 
             _______________________
            |                       |
            |    Gestion des vues   |
            |_______________________|            
    */

    /**
     * Créé une vue affichant le formulaire de création d'un objet
     */
    public function displayCreator() : void;

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     * @param [$id] identifiant de l'objet
     */
    public function displayEditor($id) : void;

    /**
     * Créé une vue affichant un objet choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public function displayObject($id) : void;

    /**
     * Créé une vue affichant tous les objets
     */
    public function displayObjects() : void;

    /* 
             _________________________
            |                         |
            |    Gestion de la bdd    |
            |_________________________|              
    */

    /**
     * Gère la création d'un objet
     */
    public function create($attr) : void;

    /**
     * Gère l'édition d'un objet
     */
    public function edit($id, $attr);

    /**
     * Gère la suppression d'un objet
     */
    public function delete($id);
}