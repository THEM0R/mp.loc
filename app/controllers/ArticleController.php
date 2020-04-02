<?php

namespace app\controllers;

use lib\App;

class ArticleController extends AppController
{


  public function indexAction($model, $route)
  {


    $article = \R::getRow('SELECT * FROM _articles WHERE url = ? AND active = ?', [$route['url'], 1]);

    if ($article) {

      $category = \R::getRow('SELECT * FROM _category WHERE id = ?', [$article['category']]);

      if ($category['url'] == 'material') {

      }

      if ($category['url'] == 'metal') {

        $this->view = 'article2';

      }

      /*
       * meta
       */
      $title = $article['name'] . ' |' . $this->title;
      if($article['description'] != '') {

        $str = str_replace('<p>', '', $article['description']);
        $str = str_replace('</p>', ' ', $str);

        $description = $str . ' ' . $this->settings['meta_description'];
      }else{
        $description = $this->settings['meta_description'];
      }

      $this->meta($title,$description);
      /*
       * meta end
       */

      if ($article['screens'] !== null) {
        $article['screens'] = explode('|', $article['screens']);
      }

      $prices = \R::getAll('SELECT * FROM _price WHERE article = ? ', [$article['id']]);

      $this->render(compact('article', 'prices'));
    } else {
      App::notFound();
    }


  }
}