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

    if ($category) {

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
      $this->render(compact('articles', 'category'));

    } else {
      App::notFound();
    }
  }


  public function priceAction($model, $route){

    /*
     * meta
     */
    $title = 'Прайс лист |' . $this->title;

    $this->meta($title);

    /*
     * category
     */

    $category = \R::getRow('SELECT * FROM _category WHERE url = ?', [$route['category']]);

    if ($category) {

      $name = (string)$category['name'];
      $url = (string)$category['url'];
      $id = (int)$category['id'];

      $category['name'] = $name;
      $category['url'] = $url;
      $category['id'] = $id;
      /*
       * articles
       */
      $headers = \R::getAll('SELECT header FROM _price WHERE category = ? GROUP by header', [$id]);
      $prices = [];

      $i = 0;
      foreach ($headers as $header){
        if($header['header'] !== null){

          $i++;
          $prices[$i]['header'] = $header['header'];
          $prices[$i]['price'] = \R::getAll('SELECT * FROM _price WHERE header = ?', [$header['header']]);

        }
      }

      $prices = array_chunk($prices, count($prices) / 2);


      /*
       * render
       */
      $this->render(compact('prices', 'category'));

    } else {
      App::notFound();
    }
  }





}