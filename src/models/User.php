<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

/**
 * Classe modèle de l'objet User de la bdd
 * construite avec l'ORM Eloquent
 */
class User extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;  

    /**
     * Définit l'association avec Liste
     */
    public function listes() : array {
        return $this->hasMany('\wishlist\models\Liste','user_id');
    }
}

?>