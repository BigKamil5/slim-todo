<?php

namespace App\Controllers\Auth;

use App\Modules\User;
use App\Controllers;
use Respect\Validation\Validator;
use App\Auth;


class AuthController extends \App\Controllers\Controller{

    public function index($request, $response){

        return $this->c->view->render($response, 'auth/signup.twig');

    }

    public function store($request, $response){


        $validation = $this->c->validator->validate($request, [
            'email'         =>  Validator::noWhitespace()->notEmpty()->email(),
            'name'          =>  Validator::notEmpty()->alpha(),
            'password'      =>  Validator::noWhitespace()->notEmpty(),
            //'name'      =>
            //'password'  =>

        ]);


        if($validation->fail()){

            //$errors = $validation->getErrors();
            return $response->withRedirect($this->c->router->pathFor('auth.index'));
        }


        $userInfo = $request->getParams();
        //$request->getParams('email');

        $user = User::create([

            'email'     =>  $userInfo['email'],
            'name'      =>  $userInfo['name'],
            'password'  =>  password_hash($userInfo['password'], PASSWORD_DEFAULT),
            
        ]);

        $this->c->auth->attempt(
            $user->email,
            $request->getParam('password')
        );

        return $response->withRedirect($this->c->router->pathFor('home'));

    }

    public function getSignIn($request,$response)
    {

        return $this->c->view->render($response, 'auth/signin.twig');
        
    }


    public function postSignIn($request,$response)
    {

        $validation = $this->c->validator->validate($request, [
            'email'         =>  Validator::noWhitespace()->notEmpty()->email(),
            'password'      =>  Validator::noWhitespace()->notEmpty(),

        ]);

        if($validation->fail())
        {

            return $response->withRedirect($this->c->router->pathFor('auth.signin'));

        }

        $auth = $this->c->auth->attempt(
            $request->getParam('email'), 
            $request->getParam('password')
        );

        if(!$auth){

            return $response->withRedirect($this->c->router->pathFor('auth.signin'));

        }


        return $response->withRedirect($this->c->router->pathFor('home'));


    }


    public function getSignOut($request,$response){

        $this->c->auth->signOut();

        return $response->withRedirect($this->c->router->pathFor('home'));

    }



}