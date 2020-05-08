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
    
    public static function getAll(){
        return $this->hasMany('\wishlist\models\User','user_id')->get();
    }


    /**
     *  Créer un utilisatuer avec un tableau associatif @param tab
     *  @return object User créer
     */
    public static function create($attributs): object{
        $User = new User;
        foreach ($tab as $key => $value) {
            if($User->$key=='password'){
                $empreinte = hash('bcrypt', $value) ;
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
        foreach ($tab as $key => $value) {
            if($this->$key=='password'){
                $empreinte = hash('bcrypt', $value) ;
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


}

?>