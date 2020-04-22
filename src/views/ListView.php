<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\View;

/**
 * Vues associées aux listes
 */
class ListView extends View {

    public function __construct($selector, $var){
        $this->selector = $selector;
        $this->var = $var;
    }

    /**
     * Formate une liste de liste
     * @return string code html
     */
    protected function list() : string{
        $slim = \Slim\Slim::getInstance();
        $newList = $slim->urlFor('newList');
        $html = <<<html

        <div class="jumbotron">
            <div class="container">
                <h1 class='display-4'>Bienvenue sur Wishlist</h1>
                <hr class="my-4">
                <a href='$newList' class="btn btn-primary" id="btn">Créer une liste</a>
            </div>
        </div>

html;

        foreach($this->var['list'] as $list){
            $showList = $slim->urlFor('showList', ['token' => $list->token]);
            $editList = $slim->urlFor('editList', ['token' => $list->token]);
            $html = $html . <<<html

        <!-- Boucler sur les listes passées en paramètre -->
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary mb-5">Les dernières listes</h1>
            <div class="card my-4">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <!-- Insérer variable nom -->
                            <h3 class="m-0"><a href='$showList'>$list->titre</a></h3>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté ? -->
                            <a href="$editList" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Insérer variable expiration -->
                    <p class="text-muted m-0">Expire le $list->expiration</p>
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
        $list = $this->var['list'];
        $updateList = $slim->urlFor('updateList', ['token' => $list->token]);
        $deleteList = $slim->urlFor('deleteList', ['token' => $list->token]);
        $home = $slim->urlFor('home');
        return <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Modifier ma liste</h1>
            <div class="card my-4 p-4">
                <form method='POST' action='$updateList'>
                    <div class="form-group mb-3">
                        <label for="list_name">Nom</label>
                        <!-- Insérer l'ancien nom de la liste -->
                        <input type="text" class="form-control" name='titre' id="list_name" value="$list->titre">
                    </div>
                    <div class="form-group mb-3">
                        <label for="list_description">Description</label>
                        <!-- Insérer l'ancienne description de la liste -->
                        <textarea class="form-control" name='description' id="list_description" rows="6" style="resize: none;">$list->description</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="expiration_date">Date d'expiration</label>
                        <!-- Insérer l'ancienne date d'expiration de la liste -->
                        <input type="date" class="form-control" name='expiration' id="expiration_date" value="$list->expiration">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Valider</button>
                        <a href="<!--$deleteList-->#" class="btn btn-danger ml-3">Supprimer</a>
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
    protected function new() : string {
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
                        <input type="text" class="form-control" id="list_name" placeholder="Nom de ma liste">
                    </div>
                    <div class="form-group mb-3">
                        <!-- Insérer l'ancienne description de la liste -->
                        <textarea class="form-control" id="list_description" rows="6" style="resize: none;" placeholder="Description de ma liste"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="expiration_date">Date d'expiration</label>
                        <input type="date" class="form-control" id="expiration_date">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="public" id="public_check">
                        <label class="form-check-label" for="public_check">
                            Liste publique
                        </label>
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
    protected function show() : string { }

}