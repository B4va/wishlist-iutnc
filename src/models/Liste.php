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
     * Définit l'association avec Item
     */
    public function items(){
        return $this->hasMany('\wishlist\models\Item','liste_id');
    }

    /**
     * Récupère tous les items associés à la liste
     * @return array tableau des items associés à la liste
     */
    public static function getAllItems() : array {
        return $this->hasMany('\wishlist\models\Item','liste_id')->get();
    }

    /**
     * Définit l'association avec User
     */
    public function user() {
        return $this->belongsTo('\wishlist\models\User','user_id');
    }

    /**
     * Récupère l'utilisateur auquel appartient la liste
     * @return User utilisateur propriétaire de la liste
     */
    public static function getUser() : User {
        return $this->belongsTo('\wishlist\models\User','user_id')->first();
    }

    /**
     *  Récupère la liste en finction de l'id
     *  @return Liste d'id $id
     */
    public static function getById($id) : Liste{
        return Liste::where('no', '=',$id)->first();
    }

    /**
     *  Récupère la liste en finction de son token
     *  @return Liste de token $token
     */
    public static function getByToken($token) : Liste{
        return Liste::where('token', '=',$token)->first();
    }

    public static function create($titre){
        $liste = new Liste;
        $liste->titre = $titre;
        $liste->save();
    }

    public static function recupererTest() : array{
        $date = date("Y-m-d");
        return array(Liste::where('expiration','>',$date)->get());
    }

    public static function updateListe($id,$tab){
        $liste = Liste::getById($id);
        foreach ($tab as $key => $value) {
            $liste->$key = $value;
        }
        $liste->save();
    }

    public static function suppListe($token){
        Liste::where('token','=',$token)->delete();
    }

}

?>