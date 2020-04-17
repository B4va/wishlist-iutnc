<?php

namespace wishlist\models;
require_once './vendor/autoload.php';
use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

class Item extends Model {

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Définit l'association avec Liste
     */
    public function liste() : Liste {
        return $this->belongsTo('\wishlist\models\Liste','liste_id');
    }
    
}

?>