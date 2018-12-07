<?php


use App\Modules\Users;
use App\Controllers\TopicController;
use App\Controllers\UserController;
use App\Controllers\ExampleController;
use App\Controllers\TasksController;
use App\Controllers\Auth\AuthController;


/* ============== AUTH GRUOP ============*/

$app->group('/auth',function(){

    $this->get('/signup',AuthController::class . ':index')->setName('auth.index');
    $this->post('/signup',AuthController::class . ':store');

    $this->get('/signin',AuthController::class . ':getSignIn')->setName('auth.signin');
    $this->post('/signin',AuthController::class . ':postSignIn');

    $this->get('/signout',AuthController::class . ':getSignout')->setName('auth.signout');

});

$app->get('/', UserController::class . ':getTasksList')->setName('home');


$app->group('/tasks',function(){

    $this->post('/add', TasksController::class . ':addTask')->setName('tasks.add');

    $this->delete('/{id}', TasksController::class . ':deleteTask')->setName('tasks.delete');

    $this->get('/{id}', TasksController::class . ':updateTask')->setName('tasks.update');
    $this->put('/{id}', TasksController::class . ':updateTaskPerm');
    
});




/* ============== ARTICLES/TOPICS GRUOP ============*/

$app->group('/topics',function(){

    $this->get('/test',function(){

        var_dump(TopicController::class.':index');

    });
    $this->get('',TopicController::class.':index');
    $this->get('/{id}',TopicController::class.':show')->setName('articles.show');

});


/* ============== USERS GRUOP ============*/
$app->group('/users',function(){

    $this->get('',UserController::class.':index');

});


$app->get('/redirect',ExampleController::class . ':redirect');
$app->get('/landing',ExampleController::class . ':landing')->setName('landing');