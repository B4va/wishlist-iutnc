<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

/**
 * Regroupe les fonctions communes aux contrôleurs
 */
abstract class Controller {

    /**
     * Teste l'authentification d'un l'utilisateur
     */
    public function authRequired() {
        if (!isset($_COOKIE['user'])){
            $slim = \Slim\Slim::getInstance();
            $slim->flash('info', 'Vous vous devez être connecté pour accéder à cette page');
            $slim->redirect($slim->urlFor('loginForm'));
        }
    }
    
    /**
     * Teste l'authentification de l'utilisateur précisé
     * @param int[$id] id de l'objet concerné par l'affichage
     */
    public function propRequired($id) {
        if ($id != unserialize($_COOKIE['user'])->id){
            $slim = \Slim\Slim::getInstance();
            $slim->flash('danger', 'Vous n\'avez pas accès à cette page');
            $slim->redirect($slim->urlFor('home'));
        }
    }

    /**
     * Valide une saisie utilisateur
     * @param array[$attr] attributs des champs de saisi
     * @param string[$redirectionUrl] url de redirection si saisie invalide
     */
    public function validate($attr, $redirectionUrl) {
        $valid = true;
        foreach($attr as $a){
            if ($a == null) $valid = false;
        }
        if (!$valid){
            $slim = \Slim\Slim::getInstance();
            $slim->flash('warning', 'Saisie invalide : tous les champs doivent être remplis');
            $slim->redirect($redirectionUrl);
        }
    }

    /**
     * Créé une vue affichant le formulaire de création d'un objet
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public abstract function displayCreator($id = null);

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     * @param int[$id] identifiant de l'objet
     */
    public abstract function displayEditor($id);

    /**
     * Créé une vue affichant un objet choisi par son id
     * @param int[$id] identifiant de l'objet
     */
    public abstract function displayObject($id);

    /**
     * Créé une vue affichant tous les objets
     */
    public abstract function displayObjects();

    /**
     * Gère la création d'un objet
     */
    public abstract function create();

    /**
     * Gère l'édition d'un objet
     * @param int[$id] id de l'objet à modifier
     */
    public abstract function edit($id);

    /**
     * Gère la suppression d'un objet
     * @param int[$id] id de l'objet à supprimer
     */
    public abstract function delete($id);
}


?>