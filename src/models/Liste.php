<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Item;
use \wishlist\models\User;
use \wishlist\models\ModelOperations;

/**
 * Modèle de la table liste en bdd
 */
class Liste extends Model implements ModelOperations {

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;  

    
    /**
     * Récupère tous les items associés à la liste
     * @return array tableau des items associés à la liste
     */
    public function getItems(){
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
     * @return object utilisateur propriétaire de la liste
     */
    public static function getUser() : object {
        return $this->belongsTo('\wishlist\models\User','user_id')->first();
    }

    /**
     *  Récupère la liste en fonction de @param id
     *  @return object en fonction de son id
     */
    public static function getById($id) : object{
        return Liste::where('no', '=',$id)->first();
    }

    /**
     *  Récupère la liste en finction de son token
     *  @return object fonction @param token
     */
    public static function getByToken($token) : object{
        return Liste::where('token', '=',$token)->first();
    }


    /**
     *  Créer une liste avec un tableau associatif @tab
     *  @return object Liste créer
     */
    public static function create($tab) : object{
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
     *  @return array non expirées
     */
    public static function getAll(){
        $date = date("Y-m-d");
        return Liste::where('expiration','>',$date)->get();
    }

    /**
     *  modifie une liste avec un tableau associatif @param tab
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

    public function isExpired(){
        $date = date("Y-m-d");
        return $this->expiration < $date;
    }
}

?>