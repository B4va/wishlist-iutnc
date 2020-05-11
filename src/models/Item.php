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
     * Supprime une liste
     */
    public function delete(){
        Item::where('id','=',$this->id)->delete();
    }

    /**
     * Retourne toutes les listes
     * @static
     * @return array listes
     */
    public static function getAll(){
        return Item::get();
    }

    /**
     * Réserve un item à un utilisateur
     * ou le "déréserve s'il en était déjà propriétaire
     * @param int[$user_id] l'id de l'utilisateur concerné
     */
    public function reserve($user_id){
        if($this->user_id == null){
            $this->user_id = $user_id;
        } else {
            $this->user_id = null;
        }
        $this->update();
    }

    /**
     * Vérifie l'état de réservation de l'item
     */
    public function isReserved(){
        return $this->user_id != null;
    }
    
}

?>