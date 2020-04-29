<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\View;

/**
 * Vues associées aux listes
 */
class ItemView extends View {

    public function __construct($selector, $var){
        parent::__construct($selector, $var);
    }

    /**
     * Formate l'affichage d'un ensemble d'item [vide]
     * @return string code html
     */
    protected function objects() : string{ }

    /**
     * Formatte un formulaire d'édition d'item
     * @return string code html
     */
    protected function edit() : string {
        $slim = \Slim\Slim::getInstance();
        $i = $this->var['object'];
        $idList = $i->liste_id;
        $editItem = $slim->urlFor('editItem', ['idList' => $idList, 'id' => $i->id]);
        $deleteItem = $slim->urlFor('deleteItem', ['idList' => $idList, 'id' => $i->id]);
        $list = $slim->urlFor('list', ["id" => $idList]);
        return <<<html

        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Modifier un souhait</h1>
            <div class="card my-4 p-4">
                <form method='post' action='$editItem'>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name='nom' id="nom" value="$i->nom">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name='description' rows="6" style="resize: none;">$i->descr</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tarif">Tarif</label>
                        <input type="number" name='tarif' class="form-control" id="tarif" value='$i->tarif'>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        <a href="$deleteItem" class="btn btn-danger ml-3">Supprimer</a>
                        <a href="$list" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                </form>
            </div>
        </div>

html;

    }

    /**
     * Formatte un formulaire de création d'item
     * @return string code html
     */
    protected function create() : string {
        $slim = \Slim\Slim::getInstance();
        $idList = $this->var['idList'];
        $createItem = $slim->urlFor('createItem', ['idList' => $idList]);
        $list = $slim->urlFor('list', ["id" => $idList]);
        return <<<html

        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Ajouter un souhait</h1>
            <div class="card my-4 p-4">
                <form method='post' action='$createItem'>
                <input type='hidden' value='$idList' name='liste_id'>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name='nom' id="nom" placeholder="Nom">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name='description' rows="6" style="resize: none;" placeholder="Description de l'item"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tarif">Tarif</label>
                        <input type="number" name='tarif' class="form-control" id="tarif" placeholder='0.00'>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        <a href="$list" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                </form>
            </div>
        </div>

html;

    }

    /**
     * Formatte l'affichage d'un item en particulier [vide]
     * @return string code html
     */
    protected function object() : string { }

}