<?php

namespace App\Controllers;


use PDO;
use App\Modules\User;



class TopicController extends Controller{


    public function index($request, $response){

        //$articles = $this->c->db->query("SELECT * FROM article")->fetchAll(PDO::FETCH_OBJ);

        //return $this->c->view->render($response, '/articles/article.index.twig', compact('articles'));

        $user = User::all();


        $kr = User::find(1)-> tasks;

        foreach ($kr as $k) {
            var_dump($k->title);
            echo "=====";
        }


        die();
        User::create([
            'name' => 'PATRUL',
            'email' => 'patrul@paturl',
            'password' => '123',
        ]);
        var_dump($user);


    }

    public function show($request, $response, $args){

        //$articleId = $args['id'];

        $article = $this->c->db->prepare("SELECT * FROM article WHERE id = :id");
        $article->execute([
            'id' => $args['id']
        ]);
        $article = $article->fetch(PDO::FETCH_OBJ);
        
        //var_dump($article);

        return $this->c->view->render($response, '/articles/article.show.twig', compact('article'));
    }

}