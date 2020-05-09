<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\View;

/**
 * Vues associées aux utilisateurs
 */
class UserView extends View {

    public function __construct($selector, $var){
        parent::__construct($selector, $var);
    }

    /**
     * Formate l'affichage d'un ensemble d'utilisateurs
     * @return string code html
     */
    protected function objects() : string{
        $slim = \Slim\Slim::getInstance();
        $html = <<<html

        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Les utilisateurs</h1>
            <ul class="list-group mt-5">

html;

        foreach($this->var['objects'] as $u){
            $user = $slim->urlFor('user', ['id' => $u->id]);
            $html = $html . <<<html
                <li class="list-group-item"><a href='$user'>$u->firstname $u->lastname</a></li>
html;
        }

        $html = $html . <<<html
            </ul>
        </div>
html;

        return $html;
    }

    /**
     * Formatte un formulaire d'édition d'utilisateur
     * @return string code html
     */
    protected function edit() : string {
        $slim = \Slim\Slim::getInstance();
        $u = $this->var['object'];
        $user = $slim->urlFor('user', ['id' => $u->id]);
        $editUser = $slim->urlFor('editUser', ['id' => $u->id]);
        return <<<html

        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Modifier mon compte</h1>
            <div class="card my-4 p-4">
                <form action="$editUser" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name='login' id="login" value="$u->login">
                    </div>
                    <div class="form-group">
                        <label class='mb-0' for="password">Nouveau mot de passe</label><br>
                        <small class='text-muted'>Taper l'ancien mot de passe pour le conserver</small>
                        <input type="password" class="form-control mt-2" name='password' id="password">
                    </div>
                    <div class="form-group">
                        <label class='mb-0' for="passwordConf">Confirmation du nouveau mot de passe</label><br>
                        <small class='text-muted'>Taper l'ancien mot de passe pour le conserver</small>
                        <input type="password" class="form-control mt-2" name='passwordConf' id="passwordConf">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" class="form-control" name='lastname' id="lastname" value="$u->lastname">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" class="form-control" name='firstname' id="firstname" value="$u->firstname">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-danger">Modifier</button>
                        <a href="$user" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                </form>
            </div>
        </div>

html;
    }

    /**
     * Formatte un formulaire de création d'utilisateur
     * @return string code html
     */
    protected function create() : string {
        $slim = \Slim\Slim::getInstance();
        $createUser = $slim->urlFor('createUser');
        $home = $slim->urlFor('home');
        $loginForm = $slim->urlFor('loginForm');

        return <<<html

        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Créer un compte</h1>
            <div class="card my-4 p-4">
                <form action="$createUser" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name='login' id="login" placeholder="login">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" name='password' id="password" placeholder="mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="password_conf">Confirmation du mot de passe</label>
                        <input type="password" class="form-control" name='password_conf' id="password" placeholder="confirmer le mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" class="form-control" name='lastname' id="lastname" placeholder="nom">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" class="form-control" name='firstname' id="firstname" placeholder="prénom">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary">Créer</button>
                        <a href="$home" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                    <div class="form-group mb-0">
                        <a href="$loginForm"><small class="text-center">Déja inscrit ? Se connecter.</small></a>
                    </form>
                </form>
            </div>
        </div>

html;
        
    }

    /**
     * Formatte l'affichage d'un utilisateur en particulier
     * @return string code html
     */
    protected function object() : string {
        $slim = \Slim\Slim::getInstance();
        $u = $this->var['object'];
        $editUser = $slim->urlFor('editorUser', ['id' => $u->id]);
        $deleteUser = $slim->urlFor('deleteUser', ['id' => $u->id]);
        $nbLists = 0;
        $html = <<<html

        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-5">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="m-0"><a href='#'>$u->firstname $u->lastname</a></h3>
                        </div>
html;
        if (View::isProperty($u->id)){
            $html = $html . <<<html

                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <a href="$editUser" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <a href="$deleteUser" class="btn btn-sm btn-outline-danger ml-3">Supprimer</a>
                        </div>
html;
        }
        $html = $html . <<<html

                    </div>
                </div>
                <div class="card-body py-4">
                    <h2 class="card-text text-muted mb-4">Listes</h2>
                    <hr>

html;
        foreach($this->var['lists'] as $l){
            $nbLists ++;
            $list = $slim->urlFor('list', ['id' => $l->no]);
            $html = $html . <<<html

                    <a href="$list"><p class="card-text mb-3">$l->titre</p></a>
html;
            if ($l->isExpired()) $html = $html . <<<html

                    <p class = 'text-muted'>Expirée</p>
html;
            $html = $html . <<<html
                    <hr>
html;
        }

        $html = $html . <<<html

                </div>
                    <div class="card-footer">
                    <p class="text-muted m-0">$nbLists liste(s)</p>
                </div>
            </div>
        </div>

html;

        return $html;
    }

    /**
     * Formatte un formulaire d'authentification
     * @return string code html
     */
    protected function authenticate() : string {
        $slim = \Slim\Slim::getInstance();
        $home = $slim->urlFor('home');
        $login = $slim->urlFor('login');
        $creatorUser = $slim->urlFor('creatorUser');
        return <<<html
        <div class="col-lg-4 offset-lg-4 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <h1 class="text-center text-primary">Se connecter</h1>
            <div class="card my-4 p-4">
                <form action="$login" method="post">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" name='login' id="login" placeholder="login">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" name='password' id="password" placeholder="mot de passe">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                        <a href="$home" class="btn btn-outline-secondary ml-3">Retour</a>
                    </div>
                    <div class="form-group mb-0">
                        <a href="$creatorUser"><small class="text-center">Pas encore inscrit ? S'inscrire</small></a>
                    </form>
                </form>
            </div>
        </div>

html;
    }

}