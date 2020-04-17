<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

/**
 * Modèle de l'objet user en bdd
 */
class User extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;  

    /**
     * Récupère les listes créées par l'utilisateur
     * @return array tableau des listes créées par l'utilisateur
     */
    public function listes() : array {
        return $this->hasMany('\wishlist\models\Liste','user_id');
    }
}

?>