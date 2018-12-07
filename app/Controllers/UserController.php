<?php

namespace App\Controllers;

use PDO;
use App\Modules\User;

class UserController extends Controller{


    public function getTasksList($request, $response){


        if(!$this->c->auth->check()){
            return $this->c->view->render($response, 'home.twig');
        }

        $tasks = User::where('id', $_SESSION['user'])->first()->tasks;

        return $this->c->view->render($response, 'home.twig',compact('tasks'));

    }




}