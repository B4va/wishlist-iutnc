<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\views\ItemView;

/**
 * Controleur associé à la gestion des item
 */
class ItemController extends Controller {

    /**
     * Créé une vue affichant le formulaire de création d'un item
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public function displayCreator($idList = null) {
        $this->authRequired();
        $l = Liste::getById($idList);
        $this->propRequired($l->user_id);
        $v = new ItemView(CREATE_VIEW, ['title' => 'Nouveau', 'idList' => $idList]);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un item
     * @param int[$id] id de l'objet à éditer
     */
    public function displayEditor($id) {
        $this->authRequired();
        $item = Item::getById($id);
        $l = $item->getListe();
        $this->propRequired($l->user_id);
        $v = new ItemView(EDIT_VIEW, ['title' => $item->nom, 'object' => $item]);
        $v->render();
    }

    /**
     * Créé une vue affichant un item choisi par son id
     * @param int[$id] identifiant de l'objet
     */
    public function displayObject($id) {}

    /**
     * Créé une vue affichant tous les items
     */
    public function displayObjects() {}

    /**
     * Gère la création d'un item
     */
    public function create() {
        $this->authRequired();
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'nom' => $slim->request->post('nom'),
            'descr' => $slim->request->post('description'),
            'tarif' => $slim->request->post('tarif'),
            'liste_id' => $slim->request->post('liste_id')
        ];
        $l = Liste::getById($attr['liste_id']);
        $this->validate($attr, $slim->urlFor('creatorItem', ['idList' => $attr['liste_id']]));
        $this->propRequired($l->user_id);
        if($attr['tarif'] < 10000 && $attr['tarif'] >= 0){
            Item::create($attr);
            $slim->flash('success', 'L\'item a été créé');
            $slim->redirect($slim->urlFor('list', ['id' => $attr['liste_id']]));
        } else {
            $slim->flash('warning', 'Le tarif doit être compris entre 0 et 10000');
            $slim->redirect($slim->urlFor('creatorItem', ['idList' => $l->no]));
        }
    }

    /**
     * Gère l'édition d'un item
     * @param int[$id] id de l'objet à modifier
     */
    public function edit($id){
        $this->authRequired();
        $i = Item::getById($id);
        $l = $i->getListe();
        $this->propRequired($l->user_id);
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'nom' => $slim->request->post('nom'),
            'descr' => $slim->request->post('description'),
            'tarif' => $slim->request->post('tarif')
        ];
        $this->validate($attr, $slim->urlFor('editorItem', ['id' => $id]));
        $i->edit($attr);
        $slim->flash('success', 'L\'item a été modifié');
        $slim->redirect($slim->urlFor('list', ['id' => $l->no]));
    }

    /**
     * Gère la suppression d'un item
     * @param int[$id] id de l'objet à supprimer
     */
    public function delete($id) {
        $this->authRequired();
        $i = Item::getById($id);
        $l = $i->getListe();
        $this->propRequired($l->user_id);
        $i->delete();
        $slim = \Slim\Slim::getInstance();
        $slim->flash('success', 'L\'item a été supprimé');
        $slim->redirect($slim->urlFor('list', ['id' => $l->no]));
    }

    /**
     * Gère la réservation d'un item
     * @param int[$id] id de l'objet à réserver
     */
    public function reserve($id){
        $slim = \Slim\Slim::getInstance();
        $this->authRequired();
        $i = Item::getById($id);
        $user_id = unserialize($_COOKIE['user'])->id;
        if($i->user_id == null || $i->user_id == $user_id){
            if ($i->reserve($user_id)){
                $slim->flash('success', 'L\'item a été réservé');
            } else {
                $slim->flash('success', 'La réservation a été annulée');
            }
        } else {
            $slim->flash('warning', 'L\'item est déjà réservé');
        }
        $slim->redirect($slim->urlFor('list', ['id' => $i->getListe()->no]));
    }

}


?>