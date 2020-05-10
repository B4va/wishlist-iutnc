<?php

namespace wishlist\controllers;

require_once './vendor/autoload.php';

use \wishlist\controllers\Controller;
use \wishlist\models\User;
use \wishlist\views\UserView;

/**
 * Controleur associé à la gestion des utilisateurs
 */
class UserController extends Controller {

    /**
     * Créé une vue affichant le formulaire de création d'un user
     * @param int[$id] id de l'objet parent, null par défaut
     */
    public function displayCreator($id = null) {
        $v = new UserView(CREATE_VIEW, ['title' => 'Nouveau']);
        $v->render();
    }

    /**
     * Créé une vue affichant le formulaire d'édition d'un user
     * @param int[$id] id de l'objet à éditer
     */
    public function displayEditor($id) {
        $this->authRequired();
        $this->propRequired($id);
        $user = User::getById($id);
        $v = new UserView(EDIT_VIEW, ['title' => $user->login, 'object' => $user]);
        $v->render();
    }

    /**
     * Créé une vue affichant un user choisi par son id
     * @param int[$id] identifiant de l'objet
     */
    public function displayObject($id) {
        $user = User::getById($id);
        $lists = $user->getLists();
        $v = new UserView(OBJECT_VIEW, ['title' => $user->login, 'object' => $user, 'lists' => $lists]);
        $v->render();
    }

    /**
     * Créé une vue affichant tous les users
     */
    public function displayObjects() {
        $ensemble = User::getAll();
        $v = new UserView(OBJECTS_VIEW, ['title' => 'Utilisateurs', 'objects' => $ensemble]);
        $v->render();
    }

    /**
     * Gère la création d'un user
     */
    public function create() {
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'login' => $slim->request->post('login'),
            'password' => $slim->request->post('password'),
            'password_conf' => $slim->request->post('password_conf'),
            'lastname' => $slim->request->post('lastname'),
            'firstname' => $slim->request->post('firstname')
        ];
        if ($attr['password'] != $attr['password_conf']) {
            $slim->flash('warning', 'Les mots de passes saisis sont différents');
            $slim->redirect($slim->urlFor('creatorUser'));
        } else if ($attr['password'] == null) {
            $slim->flash('warning', 'Aucun mot de passe saisi');
            $slim->redirect($slim->urlFor('creatorUser'));
        } else if (User::getByLogin($attr['login']) !== null) {
            $slim->flash('warning', 'Le login saisi est déja utilisé');
            $slim->redirect($slim->urlFor('creatorUser'));
        } else {
            unset($attr['password_conf']);
            $this->validate($attr, $slim->urlFor('creatorUser'));
            User::create($attr);
            $slim->flash('success', 'Vous pouvez à présent vous connecter');
            $slim->redirect($slim->urlFor('loginForm'));
        }
    }

    /**
     * Gère l'édition d'un user
     * @param int[$id] identifiant de l'objet
     */
    public function edit($id) {
        $this->authRequired();
        $this->propRequired($id);
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'password' => $slim->request->post('password'),
            'password_conf' => $slim->request->post('password_conf'),
            'lastname' => $slim->request->post('lastname'),
            'firstname' => $slim->request->post('firstname')
        ];
        if ($attr['password'] != $attr['password_conf']) {
            $slim->flash('warning', 'Les mots de passes saisis sont différents');
            $slim->redirect($slim->urlFor('editorUser', ['id' => $id]));
        } else if ($attr['password'] == null){
            $slim->flash('warning', 'Aucun mot de passe saisi');
            $slim->redirect($slim->urlFor('editorUser', ['id' => $id]));
        } else {
            $this->validate($attr, $slim->urlFor('editorUser', ['id' => $id]));
            unset($attr['password_conf']);
            User::getById($id)->edit($attr);
            setcookie('user', serialize(User::getById($id)), time()+60*60*24*30, '/');
            $slim->flash('success', 'Le profil a été mis à jour');
            $slim->redirect($slim->urlFor('user', ['id' => $id]));
        }
    }

    /**
     * Gère la suppression d'un user
     * @param int[$id] id de l'objet à supprimer
     */
    public function delete($id) {
        $this->authRequired();
        $this->propRequired($id);
        User::getById($id)->delete();
        if (isset($_COOKIE['user'])) setcookie('user', null, -1, '/');
    }

    /**
     * Créé une vue d'authentification
     */
    public function displayLogin() {
        $v = new UserView(AUTHENTICATE_VIEW, ['title' => 'Auhtentification']);
        $v->render();
    }

    /**
     * Gère l'authentification
     */
    public function loginUser() {
        $slim = \Slim\Slim::getInstance();
        $attr = [
            'login' => $slim->request->post('login'),
            'password' => $slim->request->post('password')
        ];
        if(User::loginUser($attr)){
            $slim->flash('success', 'Vous êtes à présent connecté' );
            setcookie('user', serialize(User::getByLogin($attr['login'])), time()+60*60*24*30, '/');
            $slim->redirect($slim->urlFor('home'));
        } else {
            $slim->flash('danger', 'Les informations de connexion sont erronées' );
            $slim->redirect($slim->urlFor('loginForm'));
        }
    }

    /**
     * Gère la déconnexion
     */
    public function logout() {
        $this->authRequired();
        if (isset($_COOKIE['user'])) setcookie('user', null, -1);
        $slim = \Slim\Slim::getInstance();
        $slim->flash('success', 'Vous êtes déconnecté' );
        $slim->redirect($slim->urlFor('home'));
    }

}


?>