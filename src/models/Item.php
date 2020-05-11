<?php

namespace wishlist\models;
require_once './vendor/autoload.php';
use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;
use \wishlist\models\ModelOperations;

/**
 * Modélisation d'un item inclus dans une liste
 */
class Item extends Model implements ModelOperations {

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Récupère la liste à laquelle appartient l'item
     * @return Liste liste à laquelle appartient l'item
     */
    public function getListe() {
        return $this->belongsTo('\wishlist\models\Liste','liste_id')->first();
    }

    /**
     * Récupère un Item en fonction de l'id
     * @static
     * @param int[$id] id de l'item
     * @return Item item
     */
    public static function getById($id) {
        return Item::where('id', '=',$id)->first();
    }

    /**
     * Crée un item 
     * @static
     * @param array[$tab] attributs de l'item
     * @return Item item créé
     */
    public static function create($tab) {
        $item = new Item;
        foreach ($tab as $key => $value) {
            $item->$key = $value;
        }
        $item->save();
        return $item;
    }

    /**
     * Modifie un item
     * @param array[$tab] attributs de l'item
     */
    public function edit($tab){
        foreach ($tab as $key => $value) {
            $this->$key = $value;
        }
        $this->update();
    }

    /**
     * Supprime un item
     */
    public function delete(){
        Item::where('id','=',$this->id)->delete();
    }

    /**
     * Retourne tous les item
     * @static
     * @return array items
     */
    public static function getAll(){
        return Item::get();
    }

    /**
     * Réserve un item à un utilisateur ou le "déréserve"
     * @param int[$user_id] l'id de l'utilisateur concerné
     * @return bool true si réservation, false si annulation
     */
    public function reserve($user_id){
        if($this->user_id == null){
            $this->user_id = $user_id;
            $this->update();
            return true;
        } else {
            $this->user_id = null;
            $this->update();
            return false;
        }
    }

    /**
     * Vérifie l'état de réservation de l'item
     * @return bool true si l'item est réservé
     */
    public function isReserved(){
        return $this->user_id != null;
    }

    /**
     * Récupère l'utilisateur ayant réservé l'item
     * @return object utilisateur ayant réservé l'item
     */
    public function getUser() {
        if ($this->isReserved()){
            return $this->belongsTo('\wishlist\models\User','user_id')->first();
        } else {
            return null;
        }
    }
    
}

?>