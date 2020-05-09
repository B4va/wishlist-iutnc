<?php

namespace wishlist\views;

require_once 'vendor/autoload.php';

use wishlist\views\HtmlLayout;

define ('OBJECT_VIEW', 0);
define ('OBJECTS_VIEW', 1);
define ('EDIT_VIEW', 2);
define ('CREATE_VIEW', 3);
define ('AUTHENTICATE_VIEW', 4);

/**
 * Gestion des vues
 */
abstract class View{

    protected $selector;
    protected $var;

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
            case (OBJECT_VIEW) : {
                $content = $this->object();
                break;
            }
            case (OBJECTS_VIEW) : {
                $content = $this->objects();
                break;
            }
            case (CREATE_VIEW) : {
                $content = $this->create();
            break;
            }
            case (EDIT_VIEW) : {
                $content = $this->edit();
                break;
            }
            case (AUTHENTICATE_VIEW) : {
                $content = $this->authenticate();
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
     * Formatte l'affichage d'un modèle en particulier
     * @return string code html
     */
    abstract protected function object() : string;

    /**
     * Formate l'affichage d'un ensemble de modèles
     * @return string code html
     */
    abstract protected function objects() : string;

    /**
     * Formatte un formulaire d'édition du modèle
     * @return string code html
     */
    abstract protected function edit() : string;

    /**
     * Formatte un formulaire de création du modèle
     * @return string code html
     */
    abstract protected function create() : string;

    /**
     * Formatte un formulaire d'authentification
     * @return string code html
     */
    abstract protected function authenticate() : string;

    public static function isLogin(){
        return isset($_COOKIE['user']);
    }

    public static function isProperty($userId) {
        if (View::isLogin()){
            return $userId = unserialize($_COOKIE['user'])->id == $userId;
        } else {
            return false;
        }
    }

}