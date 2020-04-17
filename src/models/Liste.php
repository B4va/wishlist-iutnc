<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Item;
use \wishlist\models\User;

/**
 * Classe modèle de l'objet Liste de la bdd
 * construite avec l'ORM Eloquent
 */
class Liste extends Model {

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;  

    /**
     * Définit l'association avec Item
     */
    public function items() : array {
        return $this->hasMany('\wishlist\models\Item','liste_id');
    }

    /**
     * Définit l'association avec User
     */
    public function user() : User {
        return $this->belongsTo('\wishlist\models\User','user_id');
    }
}

?>