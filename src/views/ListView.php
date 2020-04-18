<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\utils\HtmlLayout;

define ('LISTS_VIEW', 0);

/**
 * Vues associées aux listes
 */
class ListView{

    private $selector;
    private $var;

    /**
     * Construit la vue en fonction du sélecteur précisé
     * et enregistre les variables nécessaire au rendu, sous la
     * forme d'un tableau associatif
     * @param int[$selector] sélecteur de la vue parmis les constantes disponibles
     * @param array[$var] variables passées à la vue sous la forme d'un tableau associatif
     */
    public function __construct($selector, $var){
        $this->selector = $selector;
        $this->var = $var;
    }

    /**
     * Affiche la vue en fonction du sélecteur
     */
    public function render() : void {
        switch ($this->selector){
            case (LISTS_VIEW) : {
                $content = $this->htmlLists();
                break;
            }
        }
        echo (
            HtmlLayout::header($this->var['title']) . 
            $content . 
            HtmlLayout::footer()
        );
    }

    /**
     * Formate une liste de listes
     */
    private function htmlLists() : string{
        return <<<html

        <div class="jumbotron">
            <div class="container">
                <h1 class='display-4'>Bienvenue sur Wishlist</h1>
                <hr class="my-4">
                <button type="button" class="btn btn-primary" id="btn">Créer une liste</button>
            </div>
        </div>

        <!-- Boucler sur les listes passées en paramètre -->
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <!-- Insérer variable nom -->
                            <h3 class="m-0">Nom de la liste</h3>
                            <!-- Insérer variable auteur -->
                            <p class="text-small m-0">Auteur Delaliste</p>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté -->
                            <a href="#" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Insérer variable description -->
                    <p class="card-text">Description de la liste - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <ul class="mt-3 mb-0">
                        <!-- Boucler sur le items de la liste -->
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <!-- Insérer variable expiration -->
                    <p class="text-muted m-0">Expire le 03/04/2020</p>
                </div>
            </div>
        </div>

        <!-- Exemples à supprimer -->

        <!-- Boucler sur les listes passées en paramètre -->
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <!-- Insérer variable nom -->
                            <h3 class="m-0">Nom de la liste</h3>
                            <!-- Insérer variable auteur -->
                            <p class="text-small m-0">Auteur Delaliste</p>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté -->
                            <a href="#" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Insérer variable description -->
                    <p class="card-text">Description de la liste - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <ul class="mt-3 mb-0">
                        <!-- Boucler sur le items de la liste -->
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <!-- Insérer variable expiration -->
                    <p class="text-muted m-0">Expire le 03/04/2020</p>
                </div>
            </div>
        </div>
        <!-- Boucler sur les listes passées en paramètre -->
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <!-- Insérer variable nom -->
                            <h3 class="m-0">Nom de la liste</h3>
                            <!-- Insérer variable auteur -->
                            <p class="text-small m-0">Auteur Delaliste</p>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté -->
                            <a href="#" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Insérer variable description -->
                    <p class="card-text">Description de la liste - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <ul class="mt-3 mb-0">
                        <!-- Boucler sur le items de la liste -->
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <!-- Insérer variable expiration -->
                    <p class="text-muted m-0">Expire le 03/04/2020</p>
                </div>
            </div>
        </div>
        <!-- Boucler sur les listes passées en paramètre -->
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 my-5">
            <div class="card my-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <!-- Insérer variable nom -->
                            <h3 class="m-0">Nom de la liste</h3>
                            <!-- Insérer variable auteur -->
                            <p class="text-small m-0">Auteur Delaliste</p>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <!-- Vérifier si liste de l'utilisateur conntecté -->
                            <a href="#" class="btn btn-danger">Modifier</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Insérer variable description -->
                    <p class="card-text">Description de la liste - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <ul class="mt-3 mb-0">
                        <!-- Boucler sur le items de la liste -->
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                        <li>Item</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <!-- Insérer variable expiration -->
                    <p class="text-muted m-0">Expire le 03/04/2020</p>
                </div>
            </div>
        </div>

html;

    }

}