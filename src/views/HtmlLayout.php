<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\View;

/**
 * Classe utilitaire : template html
 */
class HtmlLayout {

    /**
     * Génère un header html
     * @static
     * @param string[$titre] titre de la page
     * @return string code htlm
     */
    public static function header(string $titre) {
        $slim = \Slim\Slim::getInstance();
        $creatorList = $slim->urlFor('creatorList');
        $home = $slim->urlFor('home');
        $login = $slim->urlFor('loginForm');
        $logout = $slim->urlFor('logout');
        $signin = $slim->urlFor('creatorUser');
        $flash = HtmlLayout::flash();
        $html = <<<html
<!DOCTYPE html>
<html lang="fr" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>$titre</title>
</head>
<body style="min-height: 100%; display: flex; flex-direction: column;">

    <header class="bg-light">
        <div class="container">
            <nav class="navbar navbar-light bg-light navbar-expand-md">
                <a class="navbar-brand" href="$home">Wishlist</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="$home">Accueil</a>
                        </li>
html;

        if (View::isLogin()){
            $user = unserialize($_COOKIE['user']);
            $profil = $slim->urlFor('user', ['id' => $user->id]);
            $html = $html . <<<html

                        <li class="nav-item">
                            <a class="nav-link" href="$creatorList">Créer une liste</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="$profil">Mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="$logout">Déconnexion</a>
                        </li>
html;
        } else {
            $html = $html . <<<html

                        <li class="nav-item">
                            <a class="nav-link" href="$login">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="$signin">S'inscrire</a>
                        </li>
html;
        }
        $html = $html . <<<html

                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div>
          
    <!-- Début contenu -->

    $flash

html;
        return $html;
    }

    /**
     * Génère un footer html
     * @static
     * @return string code htlm
     */
    public static function footer() {
        return <<<footer

        
        
    <!-- Fin contenu -->

    </div>

    <footer class="p-3 ont-small bg-light text-center" style='margin-top: auto;'>
            <p class="m-0">Projet PHP - IUT Nancy-Charlemagne</p>
            <small class="m-0 text-muted">Clément Dosda - Louis Friedrich - Loïc Steinmetz</small>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</body>
</html>
footer;

    }

    /**
     * Génère un footer html
     * @static
     * @return string code htlm
     */
    public static function flash() {
        $html = '';
        if (isset($_SESSION['slim.flash'])){
            foreach ($_SESSION['slim.flash'] as $key => $value){
                $html = $html . <<<html

        <div class="text-center col-6 offset-3 my-4 alert alert-$key" role="alert">
            $value
        </div>
html;
            }
        }
        return $html;
    }

}