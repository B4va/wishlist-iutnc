<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

abstract class Controller {

    public function authRequired() : void {
        if (!isset($_COOKIE['user'])){
            $slim = \Slim\Slim::getInstance();
            $slim->flash('info', 'Vous vous devez être connecté pour accéder à cette page');
            $slim->redirect($slim->urlFor('loginForm'));
        }
    }
    
    public function propRequired($id){
        if ($id != unserialize($_COOKIE['user'])->id){
            $slim = \Slim\Slim::getInstance();
            $slim->flash('danger', 'Vous n\'avez pas accès à cette page');
            $slim->redirect($slim->urlFor('home'));
        }
    }

    /**
     * Créé une vue affichant le formulaire de création d'un objet
     */
    public abstract function displayCreator($id = null) : void;

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     * @param [$id] identifiant de l'objet
     */
    public abstract function displayEditor($id) : void;

    /**
     * Créé une vue affichant un objet choisi par son id
     * @param [$id] identifiant de l'objet
     */
    public abstract function displayObject($id) : void;

    /**
     * Créé une vue affichant tous les objets
     */
    public abstract function displayObjects() : void;

    /**
     * Gère la création d'un objet
     */
    public abstract function create($attr) : void;

    /**
     * Gère l'édition d'un objet
     */
    public abstract function edit($id, $attr);

    /**
     * Gère la suppression d'un objet
     */
    public abstract function delete($id);
}