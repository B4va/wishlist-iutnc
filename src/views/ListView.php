<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\View;

/**
 * Vues associées aux listes
 */
class ListView extends View {

    public function __construct($selector, $var){
        parent::__construct($selector, $var);
    }

    /**
     * Formate l'affichage d'un ensemble de listes
     * @return string code html
     */
    protected function objects() : string{
        $slim = \Slim\Slim::getInstance();
        $creatorList = $slim->urlFor('creatorList');
        $html = <<<html

        <div class="jumbotron">
            <div class="container">
                <h1 class='display-4'>Bienvenue sur Wishlist</h1>
                <hr class="my-4">
                <a href='$creatorList' class="btn btn-primary" id="btn">Créer une liste</a>
            </div>
        </div>
        <h1 class="text-center text-primary mb-5">Les dernières listes</h1>

html;

        foreach($this->var['objects'] as $l){
            $list = $slim->urlFor('list', ['id' => $l->no]);
            $editorList = $slim->urlFor('editorList', ['token' => $l->token]);
            $html = $html . <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="m-0"><a href='$list'>$l->titre</a></h3>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté ? -->
                            <a href="$editorList" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-muted m-0">Expire le $l->expiration</p>
                </div>
            </div>
        </div>

html;

        }
        return $html;
    }

    /**
     * Formatte un formulaire d'édition de liste
     * @return string code html
     */
    protected function edit() : string {
        $slim = \Slim\Slim::getInstance();
        $l = $this->var['object'];
        $editList = $slim->urlFor('editList', ['token' => $l->token]);
        $deleteList = $slim->urlFor('deleteList', ['token' => $l->token]);
        $home = $slim->urlFor('home');
        return <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Modifier ma liste</h1>
            <div class="card my-4 p-4">
                <form method='POST' action='$editList'>
                    <div class="form-group mb-3">
                        <label for="list_name">Nom</label>
                        <input type="text" class="form-control" name='titre' id="list_name" value="$l->titre">
                    </div>
                    <div class="form-group mb-3">
                        <label for="list_description">Description</label>
                        <textarea class="form-control" name='description' id="list_description" rows="6" style="resize: none;">$l->description</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="expiration_date">Date d'expiration</label>
                        <input type="date" class="form-control" name='expiration' id="expiration_date" value="$l->expiration">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Valider</button>
                        <a href="$deleteList" class="btn btn-danger ml-3">Supprimer</a>
                        <a href="$home" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                </form>
            </div>
        </div>

html;

    }

    /**
     * Formatte un formulaire de création de liste
     * @return string code html
     */
    protected function create() : string {
        $slim = \Slim\Slim::getInstance();
        $createList = $slim->urlFor('createList');
        $home = $slim->urlFor('home');
        return <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Créer une liste</h1>
            <div class="card my-4 p-4">
                <form method='POST' action='$createList'>
                    <div class="form-group mb-3">
                        <label for="list_name">Nom</label>
                        <input type="text" class="form-control" id="list_name" name='titre' placeholder="Nom de ma liste">
                    </div>
                    <div class="form-group mb-3">
                        <!-- Insérer l'ancienne description de la liste -->
                        <textarea class="form-control" id="list_description" name='description' rows="6" style="resize: none;" placeholder="Description de ma liste"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="expiration_date">Date d'expiration</label>
                        <input name='expiration' type="date" class="form-control" id="expiration_date">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Valider</button>
                        <a href="$home" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                </form>
            </div>
        </div>

html;

    }

    /**
     * Formatte l'affichage d'une liste en particulier
     * @return string code html
     */
    protected function object() : string {
        $slim = \Slim\Slim::getInstance();
        $l = $this->var['object'];
        $editorList = $slim->urlFor('editorList', ['token' => $l->token]);
        $deleteList = $slim->urlFor('deleteList', ['token' => $l->token]);
        $html = <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-5">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="m-0"><a href='#'>$l->titre</a></h3>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté ? -->
                            <a href="$editorList" class="btn btn-outline-primary">Modifier</a>
                            <a href="$deleteList" class="btn btn-outline-danger ml-3">Supprimer</a>
                        </div>
                    </div>
                </div>
                <div class="card-body py-4">
                    <!-- insérer nom de l'auteur -->
                    <p class="card-text text-muted">Auteur Delaliste</small>
                    <p class="card-text mb-4">$l->description</p>
html;

        foreach($this->var['items'] as $item){
            $html = $html . <<<html
                    <hr>
                    <div class="pl-4 mt-3 row">
                        <div class="col-10">
                            <p class="card-text font-weight-bold">$item->nom</p>
                        </div>
                        <div class="col">
                            <a href="#"><img src="../assets/img/edit.png" alt="edit" style="height: 20px;"></a>
                            <a href="#"><img src="../assets/img/delete.png" alt="delete" style="height: 20px;"></a>
                        </div>
                    </div>
html
;   

        }

        $html = $html . <<<html
            </div>
                <div class="card-footer">
                <p class="text-muted m-0">$l->expiration</p>
            </div>
        </div>
        </div>

html;

        return $html;
    }

}