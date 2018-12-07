<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Task extends Model{

    protected $fillable = [
        'title',
        'user_id',
    ];
    // public function getPorperName(){

    //     if(strlen($this->email)<1){
    //         return 'gupi';
    //     }else{
    //         return $this->name.$this->email;
    //     }
    // }


}