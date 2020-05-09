<?php

namespace wishlist\models;
require_once './vendor/autoload.php';
use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;
use \wishlist\models\ModelOperations;

/**
 * Modèle de la table item en bdd
 */
class Item extends Model implements ModelOperations {

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
        return $this->liste()->first();
    }


    /**
     *  Récupère un Item en fonction de l'id
     *  @return object d'id @param id
     */
    public static function getById($id) : object{
        return Item::where('id', '=',$id)->first();
    }


    /**
     *  Créer un item avec un tableau associatif @param tab
     *  @return l'item créé
     */
    public static function create($tab) : object{
        $item = new Item;
        foreach ($tab as $key => $value) {
            $item->$key = $value;
        }
        $item->save();
        return $item;
    }


    /**
     *  modifie un item avec un tableau associatif @param tab
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
        Item::where('id','=',$this->id)->delete();
    }

    public static function getAll(){
        return Item::get();
    }
    
}

?>