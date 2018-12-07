<?php

namespace App\Auth;

use App\Modules\User;

class Auth{


    public function attempt($email, $password){


        $user = User::where('email', $email)->first();

        if(!$user){
            return false;
        }

        if(password_verify($password, $user->password)){

            $_SESSION['user'] = $user->id;

            return true;

        }


    }


    public function user(){

        return User::find($_SESSION['user']);

    }


    public function check(){

        return isset($_SESSION['user']);

    }


    public function signOut(){


        unset($_SESSION['user']);


    }


}