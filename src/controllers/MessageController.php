<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Message;

/**
 * Controleur associé à la gestion des messages
 */
abstract class MessageController {
    /**
     * Créé une vue affichant le formulaire de création d'un objet
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public abstract function displayCreator($id = null);

    /**
     * Créé une vue affichant le formulaire d'édition d'un objet
     * @param int[$id] identifiant de l'objet
     */
    public function displayEditor($id){}

    /**
     * Créé une vue affichant un objet choisi par son id
     * @param int[$id] identifiant de l'objet
     */
    public function displayObject($id){}

    /**
     * Créé une vue affichant tous les objets
     */
    public function displayObjects(){}

    /**
     * Gère la création d'un objet
     */
    public function create(){
        $this->authRequired();
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'id' => $slim->request->post('id'),
            'user_id' => unserialize($_COOKIE['user'])->id,
            'list_id' => $slim->request->post('list_id'),
            'content' => $slim->request->post('content')
        ];
        Message::create($attr);
    }

    /**
     * Gère l'édition d'un objet
     * @param int[$id] id de l'objet à modifier
     */
    public function edit($id){}

    /**
     * Gère la suppression d'un objet
     * @param int[$id] id de l'objet à supprimer
     */
    public function delete($id){
        $message = Message::getById($id);
        $list = $message->getList();
        $this->authRequired();
        $this->propRequired($message->user_id);
        $message->delete();
        $slim = \Slim\Slim::getInstance();
        $slim->redirect($slim->urlFor('list', ['id' => $list->no]));
    }
}