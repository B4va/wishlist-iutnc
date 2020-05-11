<?php

namespace wishlist\models;

require_once './vendor/autoload.php';


class Message extends Model implements ModelOperations {

	protected $table = 'message';
    protected $primaryKey = 'id';
    public $timestamps = false;  


    /**
	 * Récupère un Message à partir de son id
     * @static
	 * @param int[$id] id du Message
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
        return User::where('id', '=',$this->user_id)->first();
    }

    /**
	 * Récupère la liste associé au message
	 * @return Liste liste
	 */
    public function getList() {
        return Liste::where('id', '=',$this->list_id)->first();
    }



    /**
     * Crée un Message
     * @static
     * @param array[$attributs] attributs du Message
     * @return msg Message créé
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
     * Modifie un Message
     * @param array[$attributs] attributs du Message
     */
    public function edit($attributs){
        foreach ($attributs as $key => $value) {
            $this->$key = $value;
        }
        $this->update();
    }

    /**
     * Supprime un Message
     */
    public function delete(){
        Message::where('id','=',$this->id)->delete();
    }

}