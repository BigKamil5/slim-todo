<?php

namespace App\Controllers;

class ExampleController extends Controller{ 


    public function redirect($request, $response){


        return $response->withRedirect($this->c->router->pathFor('landing',['id'=>1]));
    }

    public function landing($request, $response){


        
        return 'landing';
    }
}