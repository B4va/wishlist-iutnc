<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;

/**
 * Modélisation d'un message
 */
class Message extends Model implements ModelOperations {

	protected $table = 'message';
    protected $primaryKey = 'id';
    public $timestamps = false;  


    /**
	 * Récupère un message à partir de son id
     * @static
	 * @param int[$id] id du message
	 * @return Message 
	 */
    public static function getById($id) {
        return Message::where('id', '=',$id)->first();
    }

    /**
	 * Récupère l'utisisateur associé au message
	 * @return User utilisateur
	 */
    public function getUser() {
        return $this->belongsTo('\wishlist\models\User','user_id')->first();
    }

    /**
	 * Récupère la liste associée au message
	 * @return Liste liste
	 */
    public function getList() {
        return $this->belongsTo('\wishlist\models\Liste','list_id')->first();
    }

     /**
	 * Retourne tous les messages
     * @static
	 * @return array messages
	 */
    public static function getAll() {
        return Message::get();
    }


    /**
     * Crée un message
     * @static
     * @param array[$attributs] attributs du message
     * @return object message créé
     */
    public static function create($attributs) {
        $msg = new Message;
        foreach ($attributs as $key => $value) {
            $msg->$key = $value;
        }
        $msg->save();
        return $msg;
    }

     /**
     * Modifie un message
     * @param array[$attributs] attributs du message
     */
    public function edit($attributs){
        foreach ($attributs as $key => $value) {
            $this->$key = $value;
        }
        $this->update();
    }

    /**
     * Supprime un message
     */
    public function delete(){
        Message::where('id','=',$this->id)->delete();
    }

}