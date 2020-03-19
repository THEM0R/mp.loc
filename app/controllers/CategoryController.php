<?php

namespace app\controllers;

use lib\App;

class CategoryController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {
    /*
     * meta
     */
    $title = 'МЕТАЛІК-PLUS |' . $this->title;

    $this->meta($title, $this->configs['about']['description'] . ' ' . $this->keywords());

    /*
     * category
     */
    $category = \R::getRow('SELECT * FROM _category WHERE url = ?', [$route['category']]);

    $name = (string)$category['name'];
    $url = (string)$category['url'];
    $id = (int)$category['id'];

    $category['name'] = $name;
    $category['url'] = $url;
    $category['id'] = $id;
    /*
     * articles
     */
    $articles = \R::getAll('SELECT * FROM _articles WHERE category = ? AND active = ?', [$id, 1]);
    /*
     * render
     */
    $this->render(compact('articles','category'));
  }
}