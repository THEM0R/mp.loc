<?php

namespace app\controllers;

use lib\App;

class ArticleController extends AppController
{

    public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


    public function indexAction($model, $route)
    {

        $title = 'МЕТАЛІК-PLUS |' . $this->title;

        $this->meta($title, $this->configs['about']['description'] . ' ' . $this->keywords());

        $products = \R::getAll('SELECT id,name,url FROM _material WHERE active = 1');

        $this->render(compact('products'));

    }
}