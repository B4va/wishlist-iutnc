<?php

namespace wishlist\models;

require_once './vendor/autoload.php';

use \Illuminate\Database\Eloquent\Model;
use \wishlist\models\Liste;

/**
 * Modèle de l'objet user en bdd
 */
class User extends Model implements ModelOperations {

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;  


    public static function getById($id){
        return User::where('id', '=',$id)->first();
    }

    public static function getByLogin($login){
        return User::where('login', '=', $login)->first();
    }
    
    public static function getAll(){
        return User::get();
    }

    public function getLists(){
        return $this->hasMany('\wishlist\models\Liste','user_id')->get();
    }


    /**
     *  Créer un utilisatuer avec un tableau associatif @param tab
     *  @return object User créer
     */
    public static function create($attributs): object{
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
     *  modifie un utilisateur avec un tableau associatif  
     *  @param attributs
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
     * Supprime un utilisateur en fonction de son id
     */
    public function delete(){
        User::where('id','=',$this->id)->delete();
    }

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