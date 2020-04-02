<?php

namespace app\controllers;

use lib\App;

class ArticleController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {

    $title = 'МЕТАЛІК-PLUS |' . $this->title;

    $this->meta($title);

    $article = \R::getRow('SELECT * FROM _articles WHERE url = ? AND active = ?', [$route['url'], 1]);

    if ($article) {

      $category = \R::getRow('SELECT * FROM _category WHERE id = ?', [$article['category']]);

      if ($category['url'] == 'material') {

      }

      if ($category['url'] == 'metal') {

        $this->view = 'article2';

      }

      if ($article['screens'] !== null) {
        $article['screens'] = explode('|', $article['screens']);
      }

      $prices = \R::getAll('SELECT * FROM _price WHERE article = ? ', [$article['id']]);

      $this->render(compact('article', 'prices'));
    }else{
      App::notFound();
    }



  }
}