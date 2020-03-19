<?php

namespace app\controllers;

use lib\App;

class CategoryController extends AppController
{

    public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


    public function indexAction($model, $route)
    {



        $category = \R::getAll('SELECT * FROM _category WHERE url = ?',[$route['category']]);

        pr1($category);

        $title = 'МЕТАЛІК-PLUS |' . $this->title;

        $this->meta($title, $this->configs['about']['description'] . ' ' . $this->keywords());

        $products = \R::getAll('SELECT id,name,url FROM _material WHERE active = 1');

        $this->render(compact('products'));

    }
}