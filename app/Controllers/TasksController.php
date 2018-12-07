<?php


namespace App\Controllers;

use Respect\Validation\Validator;
use App\Modules\Task;


class TasksController extends Controller
{


    public function addTask($request, $response){

        $validation = $this->c->validator->validate($request, [

            'task'         =>  Validator::notEmpty(),
        
        ]);


        if($validation->fail()){

            return $response->withRedirect($this->c->router->pathFor('home'));

        }

        $taskInfo = $request->getParams();

        $task = Task::create([
 
            'title'         =>      $taskInfo['task'],
            'user_id'       =>      $_SESSION['user']

        ]);

        return $response->withRedirect($this->c->router->pathFor('home'));

    }

    public function deleteTask($request, $response, $args){
    
        Task::find($args['id'])->delete();

        return $response->withRedirect($this->c->router->pathFor('home'));

    }


    public function updateTask($request, $response, $args){
    
        $task = Task::find($args['id']);

        return $this->c->view->render($response,'tasks/updatetask.twig',compact('task'));
    }


    public function updateTaskPerm($request, $response, $args){


        $validation = $this->c->validator->validate($request, [

            'task'         =>  Validator::notEmpty(),
        
        ]);


        if($validation->fail()){

            return $response->withRedirect($this->c->router->pathFor('tasks.update',['id' => $args['id']]));

        }
    
        $task = Task::find($args['id']);

        Task::find($args['id'])->update([
            'title' => $request->getParam('task')
        ]);

        return $response->withRedirect($this->c->router->pathFor('home'));
        //return $this->c->view->render($response,'tasks/updatetask.twig',compact('task'));
    }



}