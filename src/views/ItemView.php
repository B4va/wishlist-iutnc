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
        return <<<html

        

html;

    }

    /**
     * Formatte un formulaire de création d'item
     * @return string code html
     */
    protected function create() : string {
        return <<<html

        

html;

    }

    /**
     * Formatte l'affichage d'un item en particulier [vide]
     * @return string code html
     */
    protected function object() : string { }

}