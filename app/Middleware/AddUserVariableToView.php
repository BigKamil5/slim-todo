<?php

namespace App\Middleware;

class AddUserVariableToView extends Middleware
{

    public function __invoke($request, $response, $next){


        if(isset($_SESSION['user'])){

            $this->c->view->getEnvironment()->addGlobal('user', [
            
                'check' => $this->c->auth->check(),
                'user' => $this->c->auth->user()
        
            ]);
        };

        return $next($request, $response);

    }
    


}