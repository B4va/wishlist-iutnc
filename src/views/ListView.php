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
    protected function objects() {
        $slim = \Slim\Slim::getInstance();
        $creatorList = $slim->urlFor('creatorList');
        $users = $slim->urlFor('users');
        $welcome = View::isLogin() ? unserialize($_COOKIE['user'])->firstname : 'sur Wishlist';
        $html = <<<html

        <div class="jumbotron">
            <div class="container">
                <h1 class='display-4'>Bienvenue $welcome</h1>
                <hr class="my-4">
                <a href='$creatorList' class="btn btn-primary" id="btn">Créer une liste</a>
                <a href='$users' class="btn btn-outline-secondary ml-3" id="btn">Tous les utilisateurs</a>
            </div>
        </div>
        <h1 class="text-center text-primary mb-5">Les dernières listes</h1>

html;

        foreach($this->var['objects'] as $l){
            $list = $slim->urlFor('list', ['id' => $l->no]);
            $editorList = $slim->urlFor('editorList', ['token' => $l->token]);
            $author = $l->getUser();
            $user = $slim->urlFor('user', ['id' => $author->id]);
            $html = $html . <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="m-0"><a href='$list'>$l->titre</a></h3>
                            <small><a class='text-muted' href='$user'>$author->firstname $author->lastname</a></small>
                        </div>
html;
            if (View::isProperty($l->user_id)){
                $html = $html . <<<html

                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté ? -->
                            <a href="$editorList" class="btn btn-sm btn-outline-danger">Modifier</a>
                        </div>
html;
            }
            $html = $html . <<<html

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
    protected function edit() {
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
    protected function create() {
        $slim = \Slim\Slim::getInstance();
        $createList = $slim->urlFor('createList');
        $home = $slim->urlFor('home');
        $userId = unserialize($_COOKIE['user'])->id;
        return <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Créer une liste</h1>
            <div class="card my-4 p-4">
                <form method='POST' action='$createList'>
                    <input type='hidden' name='user_id' value='$userId'>
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
    protected function object() {
        $slim = \Slim\Slim::getInstance();
        $l = $this->var['object'];
        $editorList = $slim->urlFor('editorList', ['token' => $l->token]);
        $deleteList = $slim->urlFor('deleteList', ['token' => $l->token]);
        $creatorItem = $slim->urlFor('creatorItem', ['idList' => $l->no]);
        $createMessage = $slim->urlFor('createMessage');
        $html = <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-5">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="m-0"><a href='#'>$l->titre</a></h3>
                        </div>
html;
        if (View::isProperty($l->user_id)){
            $html = $html . <<<html

                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <a href="$editorList" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <a href="$deleteList" class="btn btn-sm btn-outline-danger ml-3">Supprimer</a>
                        </div>
html;
        }
        $u = $l->getUser()->firstname . ' ' . $l->getUser()->lastname;
        $html = $html . <<<html

                    </div>
                </div>
                <div class="card-body py-4">
                    <p class="card-text text-muted">$u</p>
                    <p class="card-text mb-4">$l->description</p>
html;

        foreach($this->var['items'] as $item){
            $editItem = $slim->urlFor('editorItem', ["id" => $item->id]);
            $deleteItem = $slim->urlFor('deleteItem', ["id" => $item->id]);
            $res = $slim->urlFor('reserveItem', ["id" => $item->id]);
            $html = $html . <<<html
            
                    <hr>
                    <div class="pl-4 mt-3 row">
                        <div class="col-10">
                            <p class="card-text font-weight-bold m-0">$item->nom</p>
html;
            if ($item->isReserved()){
                $u = $slim->urlFor('user', ['id' => $item->user_id]);
                $user = $item->getUser();
                if (View::isProperty($item->user_id)){
                    $html = $html . <<<html

                            <small>Réservé par <a href='$u'>$user->firstname $user->lastname</a> (<a href='$res'>annuler la réservation</a>)</small>
                        </div>
html;
                } else {
                    $html = $html . <<<html

                            <small>Réservé par <a href='$u'>$user->firstname $user->lastname</a></small>
                        </div>
html;
                }
            } else {
                $html = $html . <<<html

                            <small><a href='$res'>Réserver</a></small>
                        </div>
html;
            }
            if (View::isProperty($l->user_id)){
                $html = $html . <<<html

                        <div class="col">
                            <a href="$editItem"><img src="../assets/img/edit.png" alt="edit" style="height: 20px;"></a>
                            <a href="$deleteItem"><img src="../assets/img/delete.png" alt="delete" style="height: 20px;"></a>
                        </div>
html
;   
            }
        $html = $html . <<<html
        
                    </div>
html;
        }
        if (View::isProperty($l->user_id)){
            $html = $html . <<<html
                    <hr>
                    <a href='$creatorItem' class='btn btn-sm btn-outline-dark mt-2 ml-4'>
                        <span class='font-weight-bold'>Ajouter</span>
                    </a>
html;
        }
        $html = $html . <<<html

                </div>
                <div class="card-footer">
                    <p class="text-muted m-0">Expire le $l->expiration</p>
                </div>
            </div>
        
            <h3 class='h4'>Messages</h3>
            <hr>

html;

        if (count($this->var['messages']) > 0){
            foreach ($this->var['messages'] as $message){
                $sender = $message->getUser();
                $senderUrl = $slim->urlFor('user', ['id' => $sender->id]);
                $deleteMessage = $slim->urlFor('deleteMessage', ['id' => $message->id]);
                $html = $html . <<<html

            <p>
                <small><a href='$senderUrl'>$sender->firstname $sender->lastname</a></small>
html;
                if (View::isProperty ($message->user_id)){
                    $html = $html . " <small>(<a href='$deleteMessage'>supprimer</a>)</small>";
                }

                $html = $html . <<<html

                <br>
                $message->content
            <p>
            <hr>
html
;                
            }
        } else {
            $html = $html . <<<html

            <p class='font-italic text-muted'>Aucun message<p>
html;
        }

        $html = $html . <<<html

            <form method='post' action='$createMessage'>
                <input type='hidden' name='list_id' value='$l->no'>
                <div class="form-group mb-3">
                    <!-- Insérer l'ancienne description de la liste -->
                    <textarea class="form-control" name='content' rows="4" style="resize: none;" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Envoyer</button>
                </div>
            </form>

        </div>

html;
        return $html;
    }

    /**
     * Formatte un formulaire d'authentification
     * @return string code html
     */
    protected function authenticate() { }

}