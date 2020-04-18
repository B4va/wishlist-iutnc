<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\utils\HtmlLayout;

define ('PUBLIC_LISTS_VIEW', 0);

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

    public function render(){
        switch ($this->selector){
            case (PUBLIC_LISTS_VIEW) : {
                $content = $this->htmlPublicLists();
                break;
            }
        }
        echo (
            HtmlLayout::header($this->var['title']) . 
            $content . 
            HtmlLayout::footer()
        );
    }

    private function htmlPublicLists(){
        return <<<html

        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">Salut le gang !</h1>
                <button type="button" class="btn btn-primary" id="btn">Vas y clique !</button>
            </div>
        </div>
        
html;

    }

}