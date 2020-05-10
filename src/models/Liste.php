<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Item;
use \wishlist\models\User;
use \wishlist\models\ModelOperations;

/**
 * Modélisation d'une liste
 */
class Liste extends Model implements ModelOperations {

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;  

    
    /**
     * Récupère tous les items associés à la liste
     * @return array items associés à la liste
     */
    public function getItems() {
        return $this->hasMany('\wishlist\models\Item','liste_id')->get();
    }

    /**
     * Récupère l'utilisateur auquel appartient la liste
     * @return object utilisateur propriétaire de la liste
     */
    public function getUser() {
        return $this->belongsTo('\wishlist\models\User','user_id')->first();
    }

    /**
     * Récupère la liste en fonction de son id
     * @static
     * @param int[$id] id de la liste
     * @return Liste liste
     */
    public static function getById($id) {
        return Liste::where('no', '=',$id)->first();
    }

    /**
     * Récupère la liste en finction de son token
     * @static
     * @param string[$token] token de la liste
     * @return Liste liste
     */
    public static function getByToken($token) {
        return Liste::where('token', '=',$token)->first();
    }


    /**
     * Crée une liste
     * @static
     * @param array[$tab] attributs de la liste
     * @return Liste Liste créée
     */
    public static function create($tab) {
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
     * Récupère les listes non expirées
     * @static
     * @return array listes non expirées
     */
    public static function getAll(){
        $date = date("Y-m-d");
        return Liste::where('expiration','>',$date)->get();
    }

    /**
     * Modifie une liste
     * @param array[$tab] attributs de la liste
     */
    public function edit($tab){
        foreach ($tab as $key => $value) {
            $this->$key = $value;
        }
        $this->update();
    }

    /**
     * Supprime une liste
     */
    public function delete(){
        Liste::where('token','=',$this->token)->delete();
    }

    /**
     * Indique si une liste est expirée
     * @return bool true si la liste est expirée
     */
    public function isExpired(){
        $date = date("Y-m-d");
        return $this->expiration < $date;
    }
}

?>