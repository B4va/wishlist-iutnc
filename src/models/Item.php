<?php

namespace wishlist\models;
require_once './vendor/autoload.php';
use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

/**
 * Modèle de la table item en bdd
 */
class Item extends Model {

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Définit l'association avec Liste
     */
    public function liste() {
        return $this->belongsTo('\wishlist\models\Liste','liste_id');
    }

    /**
     * Récupère la liste à laquelle appartient l'item
     * @return Liste liste à laquelle appartient l'item
     */
    public static function getListe() : Liste {
        return $this->belongsTo('\wishlist\models\Liste','liste_id')->first();
    }
    
}

?>