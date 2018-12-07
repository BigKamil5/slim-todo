<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $fillable = [
        'email',
        'name',
        'password',
    ];
    // public function getPorperName(){

    //     if(strlen($this->email)<1){
    //         return 'gupi';
    //     }else{
    //         return $this->name.$this->email;
    //     }
    // }


    public function tasks(){

     
        return $this->hasMany('App\Modules\Task');


    }
}