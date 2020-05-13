<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;
use \wishlist\models\Message;

/**
 * Modélisation d'un utilisateur
 */
class User extends Model implements ModelOperations {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;  

    /**
	 * Récupère un utilisateur à partir de son id
     * @static
	 * @param int[$id] id de l'utilisateur
	 * @return User utilisateur
	 */
    public static function getById($id) {
        return User::where('id', '=',$id)->first();
    }

    /**
	 * Récupère un utilisateur à partir de son login
     * @static
	 * @param string[$login] id de l'utilisateur
	 * @return User utilisateur
	 */
    public static function getByLogin($login) {
        return User::where('login', '=', $login)->first();
    }
    
    /**
	 * Retourne tous les utilisateurs
     * @static
	 * @return array utilisateurs
	 */
    public static function getAll() {
        return User::get();
    }

    /**
	 * Retourne les listes de l'utilisateur
	 * @return array listes
	 */
    public function getLists() {
        return $this->hasMany('\wishlist\models\Liste','user_id')->get();
    }

    /**
     * Récupère tous les messages associés à l'utilisateur
     * @return array messages associés à l'utilisateur
     */
    public function getMessages(){
        return $this->hasMany('\wishlist\models\Message','user_id')->get();
    }

    /**
     * Crée un utilisatuer
     * @static
     * @param array[$attributs] attributs de l'utilisateur
     * @return User utilisateur créé
     */
    public static function create($attributs) {
        $User = new User;
        foreach ($attributs as $key => $value) {
            if($key=='password'){
                $empreinte = password_hash($value, PASSWORD_DEFAULT);
                $User->$key = $empreinte;
            }
            else{
                $User->$key = $value;
            }
        }
        $User->save();
        return $User;
    }

    /**
     * Modifie un utilisateur
     * @param array[$attributs] attributs de l'utilisateur
     */
    public function edit($attributs){
        foreach ($attributs as $key => $value) {
            if($key=='password'){
                $empreinte = password_hash($value, PASSWORD_DEFAULT);
                $this->$key = $empreinte;
            }
            else{
                $this->$key = $value;
            }
        }
        $this->update();
    }

    /**
     * Supprime un utilisateur
     */
    public function delete(){
        User::where('id','=',$this->id)->delete();
    }

    /**
     * Teste la connexion d'un utilisateur
     * @param array[$form] login et mot de passe
     * @return bool true si la connexion est valide
     */
    public function loginUser($form){
        $user = User::where('login', '=', $form['login'])->first();
        if($user == null){
            return false;
        } else {
            return password_verify($form['password'], $user->password);
        }
    }
}

?>