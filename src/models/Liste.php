<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Item;
use \wishlist\models\User;

/**
 * Modèle de la table liste en bdd
 */
class Liste extends Model implements modelOperations {

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


    /**
     *  Créer une liste avec un tableau associatif $tab
     *  @return la Liste créer
     */
    public static function create($tab) : Liste{
        $liste = new Liste;
        foreach ($tab as $key => $value) {
            $liste->$key = $value;
        }
        // ajouter le user id
        $liste->token = uniqid();
        $liste->save();
        return $liste;
    }

    /**
     *  Récupère les listes non expirées
     *  @return Liste non expirées
     */
    public static function getLists(){
        $date = date("Y-m-d");
        return Liste::where('expiration','>',$date)->get();
    }

    /**
     *  modifie une liste avec un tableau associatif $tab
     */
    public function edit($tab){
        foreach ($tab as $key => $value) {
            $this->$key = $value;
        }
        $this->update();
    }

    /**
     * Supprime une liste en fonction de son token
     */
    public function delete(){
        Liste::where('token','=',$this->token)->delete();
    }

}

?>