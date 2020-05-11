<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Liste;
use \wishlist\views\ListView;

/**
 * Controleur associé à la gestion des listes
 */
class ListController extends Controller {

    /**
     * Créé une vue affichant le formulaire de création d'une liste
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public function displayCreator($idList = null) {
        $this->authRequired();
        $v = new ListView(CREATE_VIEW, ['title' => 'Nouveau']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'une liste
     * @param int[$token] token de l'objet à éditer
     */
    public function displayEditor($token) {
        $this->authRequired();
        $list = Liste::getByToken($token);
        $this->propRequired($list->user_id);
        $v = new ListView(EDIT_VIEW, ['title' => $list->titre, 'object' => $list]);
        $v->render();
    }

    /**
     * Créé une vue affichant une liste choisie par son id
     * @param int[$id] identifiant de l'objet
     */
    public function displayObject($id) {
        $list = Liste::getById($id);
        $items = $list->getItems();
        $v = new ListView(OBJECT_VIEW, ['title' => $list->titre, 'object' => $list, 'items' => $items]);
        $v->render();
    }

    /**
     * Créé une vue affichant toutes les listes
     */
    public function displayObjects() {
        $ensemble = Liste::getAll();
        $v = new ListView(OBJECTS_VIEW, ['title' => 'Listes', 'objects' => $ensemble]);
        $v->render();
    }

    /**
     * Gère la création d'une liste
     */
    public function create() {
        $this->authRequired();
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'user_id' => $slim->request->post('user_id'),
            'titre' => $slim->request->post('titre'),
            'description' => $slim->request->post('description'),
            'expiration' => $slim->request->post('expiration')
        ];
        $this->validate($attr, $slim->urlFor('creatorList'));
        Liste::create($attr);
        $slim->flash('success', 'La liste a été créée');
        $lists = unserialize($_COOKIE['user'])->getLists();
        $list = $lists[count($lists)- 1];
        $slim->redirect($slim->urlFor('list', ['id' => $list->no]));
    }

    /**
     * Gère l'édition d'une liste
     * @param int[$token] token de l'objet
     */
    public function edit($token){
        $this->authRequired();
        $slim = \Slim\Slim::getInstance();
        $l = Liste::getByToken($token);
        $this->propRequired($l->user_id);
        $attr = [
            'titre' => $slim->request->post('titre'),
            'description' => $slim->request->post('description'),
            'expiration' => $slim->request->post('expiration')
        ];
        $this->validate($attr, $slim->urlFor('editorList', ['token' => $token]));
        $l->edit($attr);
        $slim->flash('success', 'La liste a été modifiée');
        $slim->redirect($slim->urlFor('list', ['id' => $l->no]));
    }

    /**
     * Gère la suppression d'une liste
     * @param int[$token] token de l'objet à supprimer
     */
    public function delete($token) {
        $this->authRequired();
        $l = Liste::getByToken($token);
        $this->propRequired($l->user_id);
        foreach($l->getItems() as $i) $i->delete();
        $l->delete();
        $slim = \Slim\Slim::getInstance();
        $slim->flash('success', 'La liste a été supprimée');
        $slim->redirect($slim->urlFor('home'));
    }
}


?>