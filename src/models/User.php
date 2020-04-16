<?php

namespace wishlist\models;
require_once './vendor/autoload.php';
use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

class Liste extends Model {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;  

    public function listes() {
        return $this->hasMany('\wishlist\models\Liste','user_id');
    }
}

?>