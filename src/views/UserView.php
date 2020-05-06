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
        
    }

    /**
     * Formatte un formulaire d'édition d'utilisateur
     * @return string code html
     */
    protected function edit() : string {

    }

    /**
     * Formatte un formulaire de création d'utilisateur
     * @return string code html
     */
    protected function create() : string {
        
    }

    /**
     * Formatte l'affichage d'un utilisateur en particulier
     * @return string code html
     */
    protected function object() : string {
        
    }

    /**
     * Formatte un formulaire d'authentification
     * @return string code html
     */
    protected function authenticate() : string {

    }

}