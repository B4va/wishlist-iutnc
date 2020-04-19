<?php

namespace wishlist\views;

/**
 * Gestion des vues
 */
require_once 'vendor/autoload.php';

use wishlist\utils\HtmlLayout;

define ('LIST_VIEW', 0);
define ('EDIT_VIEW', 1);
define ('NEW_VIEW', 2);
define ('SHOW_VIEW', 3);

abstract class View{

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
            case (LIST_VIEW) : {
                $content = $this->list();
                break;
            }
            case (EDIT_VIEW) : {
                $content = $this->edit();
                break;
            }
            case (NEW_VIEW) : {
                $content = $this->new();
                break;
            }
            case (SHOW_VIEW) : {
                $content = $this->show();
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
     * Formate une liste de modèles
     * @return string code html
     */
    abstract protected function list() : string;

    /**
     * Formatte un formulaire d'édition du modèle
     * @return string code html
     */
    abstract protected function edit() : string;

    /**
     * Formatte un formulaire de création du modèle
     * @return string code html
     */
    abstract protected function new() : string;

    /**
     * Formatte l'affichage d'un modèle en particulier
     * @return string code html
     */
    abstract protected function show() : string;

}