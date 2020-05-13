<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Message;

/**
 * Contrôleur associé à la gestion des messages
 */
class MessageController extends Controller {
    /**
     * Créé une vue affichant le formulaire de création d'un message
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public function displayCreator($id = null){}

    /**
     * Créé une vue affichant le formulaire d'édition d'un message
     * @param int[$id] identifiant du message
     */
    public function displayEditor($id){}

    /**
     * Créé une vue affichant le message choisi par son id
     * @param int[$id] identifiant du message
     */
    public function displayObject($id){}

    /**
     * Créé une vue affichant tous les messages
     */
    public function displayObjects(){}

    /**
     * Gère la création d'un message
     */
    public function create(){
        $this->authRequired();
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'user_id' => unserialize($_COOKIE['user'])->id,
            'list_id' => $slim->request->post('list_id'),
            'content' => $slim->request->post('content')
        ];
        Message::create($attr);
        $slim->flash('success', 'Le message a été ajouté');
        $slim->redirect($slim->urlFor('list', ['id' => $attr['list_id']]));
    }

    /**
     * Gère l'édition d'un message
     * @param int[$id] id du message à modifier
     */
    public function edit($id){}

    /**
     * Gère la suppression d'un message
     * @param int[$id] id du message à supprimer
     */
    public function delete($id){
        $this->authRequired();
        $message = Message::getById($id);
        $this->propRequired($message->user_id);
        $list = $message->getList();
        $message->delete();
        $slim = \Slim\Slim::getInstance();
        $slim->flash('success', 'Le message a été supprimé');
        $slim->redirect($slim->urlFor('list', ['id' => $list->no]));
    }
}


?>