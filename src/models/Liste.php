<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Item;
use \wishlist\models\User;

/**
 * Modèle de la table liste en bdd
 */
class Liste extends Model {

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;  

    /**
     * Récupère les items associés à la liste
     * @return array tableau des items associés à la liste
     */
    public function items() : array {
        return $this->hasMany('\wishlist\models\Item','liste_id');
    }

    /**
     * Récupère l'utilisateur auquel appartient la liste
     * @return User utilisateur propriétaire de la liste
     */
    public function user() : User {
        return $this->belongsTo('\wishlist\models\User','user_id');
    }
}

?>