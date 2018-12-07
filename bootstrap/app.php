<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

// $config['displayErrorDetails'] = true;
// $config['addContentLengthHeader'] = false;

// $config['db']['host']   = 'localhost';
// $config['db']['user']   = 'root';
// $config['db']['pass']   = '';
// $config['db']['dbname'] = 'slim';

session_start();


$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim_todo',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ]
]);

$container = $app->getContainer();


$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// $container['db'] = function(){
//     return new PDO('mysql:host=localhost;dbname=slim','root','');
// };

$container['db'] = function($container) use ($capsule){

    return $capsule;
};

$container['validator'] = function($container){

    return new App\Validation\Validator;

};

$container['csrf'] = function($container){

    return new \Slim\Csrf\Guard;
};

$container['auth'] = function($container){

    return new \App\Auth\Auth;
};


$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
$app->add(new \App\Middleware\AddUserVariableToView($container));
$app->add($container->csrf);


// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../resources/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

require __DIR__ . '/../routes/web.php';

/*
$container['db'] = function(){
    return new PDO('mysql:host=localhost;dbname=slim','root','');
};

$app->get('/',function($request, $response){

    $users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_OBJ);

    var_dump($users);

    echo "=====================================";

    $users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

    var_dump($users);

    foreach($users as $user){

        echo $user['ID'].'</br>';
    };
    
    //return $this->view->render($response,'home.twig');

})->setName('home.index');

$app->get('/users/{name}',function($request, $response, $args){

    $name = $args['name'];

    return $this->view->render($response,'users.twig',[
        'name' => $name,
    ]);

})->setName('profile');


//kontener - SINGLETON abc zostanie wypisane tylko raz,pomimo ze uzye w roucie  kontenera np 2100 razy
$container['kra'] = function(){
    echo 'abc';
    return "KRAKRKARKAKR";
};

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    //var_dump($request);
    $name = $args['name'];
    $response->getBody()->write("Hello, $name, $this->kra");

    return $response;
});

static $bla = 1;

$app->get('/test',function() use (&$bla){

    $bla ++;
    echo __DIR__;
});

$app->get('/error',function() use (&$bla){

    echo $this->noth;
});

$app->get('/contact', function($request, $response){

    return $this->view->render($response, 'contact.twig');

});

$app->get('/contact/confirm', function($request, $response){

    var_dump($response->getBody());

    return $this->view->render($response, 'contact_confirm.twig');

});

$app->post('/contact', function($request, $response){

    //die('daj contact');
    $result = $request->getParsedBody();
    var_dump($request->getParsedBody());
    echo '===================';

    var_dump($request->getParams());
    echo '===================';
    var_dump($_POST["email"]);
    echo '===================';
    var_dump($result['name']);

    return $response->withRedirect('http://slim.kam/contact/confirm');

})->setName('contact');

// $app->post('/ticket/new', function (Request $request, Response $response) {
//     $data = $request->getParsedBody();
//     $ticket_data = [];
//     $ticket_data['title'] = filter_var($data['title'], FILTER_SANITIZE_STRING);
//    // $ticket_data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING);

//     $response->getBody()->write("Hello ".$ticket_data['title']);

// });

require_once('../app/api/books.php');

$app->run();

*/