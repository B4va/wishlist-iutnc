<?php

namespace wishlist\utils;

require_once 'vendor/autoload.php';

/**
 * Classe utilitaire : template html
 */
class HtmlLayout {

    /**
     * Génère un header html
     * @static
     * @param string[$titre] titre de la page
     * @return string header
     */
    public static function header(string $titre) : string {
        return <<<header
<!DOCTYPE html>
<html lang="fr" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>$titre</title>
</head>
<body style="height: 100%; display: flex; flex-direction: column;">

    <header class="bg-light">
        <div class="container">
            <nav class="navbar navbar-light bg-light navbar-expand-md">
                <a class="navbar-brand" href="#">Wishlist</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Accueil<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Créer une liste</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mes listes</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div style="height: 100%;">

    <!-- Début contenu -->

header;

    }

    /**
     * Génère un footer html
     * @static
     * @return string footer
     */
    public static function footer() : string {
        return <<<footer

    <!-- Fin contenu -->

    </div>

    <footer class="p-3 ont-small bg-light text-center">
            <p class="m-0">Projet PHP - IUT Nancy-Charlemagne</p>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</body>
</html>
footer;

    }

}