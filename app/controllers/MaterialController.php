<?php

namespace app\controllers;

use lib\App;

class MaterialController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {

    $title = 'Матеріали |' . $this->title;

    $this->meta($title, $title . ' ' . $this->configs['about']['description']);

    $products = \R::getAll('SELECT id,name,url FROM _material WHERE active = 1');

    $this->render(compact('products'));
  }

  public function productAction($model, $route)
  {

    if (in_array($route['product'], \R::getCol('SELECT url FROM _material WHERE active = 1'))) {


      $colors = [

          1 => [
              'name' => 3005,
              'color' => '59191f',
          ],
          2 => [
              'name' => 3011,
              'color' => '792423',
          ],
          3 => [
              'name' => 8004,
              'color' => '8d4931',
          ],
          4 => [
              'name' => 8017,
              'color' => '442f29',
          ],
          5 => [
              'name' => 8019,
              'color' => '231b18',
          ],


          7 => [
              'name' => 6005,
              'color' => '114232',
          ],
          8 => [
              'name' => 6020,
              'color' => '37422f',
          ],
          9 => [
              'name' => 6029,
              'color' => '006f3d',
          ],
          11 => [
              'name' => 5002,
              'color' => '00387b',
          ],
          12 => [
              'name' => 9003,
              'color' => 'ecece7',
          ],
          13 => [
              'name' => 9006,
              'color' => 'a1a1a0',
          ],
          14 => [
              'name' => 9005,
              'color' => '0e0e10',
          ],
          15 => [
              'name' => 1015,
              'color' => 'e6d2b5',
          ],
          16 => [
              'name' => 1003,
              'color' => 'f9a800',
          ]

      ];

      //pr($route);

      $gallery2 = null;

      $logo = \R::getCol('SELECT `name` FROM `_material` WHERE `active` = 1 AND `url` = ? LIMIT 1', [$route['product']])[0];
      $id = \R::getCol('SELECT `id` FROM `_material` WHERE `active` = 1 AND `url` = ? LIMIT 1', [$route['product']])[0];
      $info = \R::getCol('SELECT `info` FROM `_material` WHERE `active` = 1 AND `url` = ? LIMIT 1', [$route['product']])[0];

      $title = $logo . ' |' . $this->title;

      $this->meta($title, $title . ' ' . $this->configs['about']['description']);

      $gallery = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 5);

      $colors_m = false;

      if ($route['product'] == 'corrugated-board') {

        $colors_m = true;

        $this->view = 'corrugated_board';

        $gallery = $this->format('images/articles/material/' . $route['product'] . '/format');

        $gallery2 = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 1);


      }

      if ($route['product'] == 'fartherman') {

        $this->view = 'corrugated_board';

        $gallery = $this->format('images/articles/material/' . $route['product'] . '/format');

        $gallery2 = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 1);


      }


      if ($route['product'] == 'metal-tile') {

        $this->view = 'corrugated_board';

        $gallery = $this->format('images/articles/material/' . $route['product'] . '/format');

        $gallery2 = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 1);


      }


      // block-house
      if ($route['product'] == 'block-house') {

        $gallery = $this->format('images/articles/material/' . $route['product'] . '/format');

        $gallery2 = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 5);

      }

      if ($route['product'] == 'euro-bar') {

        $gallery = $this->format('images/articles/material/' . $route['product'] . '/format');

        $gallery2 = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = ?', [$id]), 5);


      }


      $products = \R::getAll('SELECT * FROM `_material_' . $route['product'] . '` WHERE active = 1');


      $this->render(compact('products', 'logo', 'id', 'info', 'gallery', 'gallery2', 'colors', 'colors_m'));


    } else {

      App::notFound();
    }

  }

  public function viewAction($model, $route)
  {

    if (in_array($route['product'], \R::getCol('SELECT url FROM _material WHERE active = 1'))) {

      //pr1($route);
      $products = \R::getAll('SELECT * FROM `_material_' . $route['product'] . '` WHERE url = ? AND active = 1 LIMIT 1', [$route['url']])[0];


      $logo = $products['name'] . ' ' . $products['kind'];

      $title = $logo . ' |' . $this->title;

      $this->meta($title, $title . ' ' . $this->configs['about']['description']);


      //pr1($product);

      $this->render(compact('products', 'logo'));


    } else {

      App::notFound();
    }

  }


  private function format($dir)
  {

    $html = '';

    $i = 0;

    foreach (scandir(CONTENT . $dir, 1) as $img) {

      $i++;

      $file = CONTENT . $dir . '/' . $img;

      if (is_file($file)) {

        // style="display:none"

        if ($i == 1) {

          $html .= '<a href="/public/' . $dir . '/' . $img . '" title="' . $img . '" class="js-img-viwer" data-group="format">';
          $html .= '<img src="/public/' . $dir . '/' . $img . '">';
          $html .= '</a>';

        } else {
          $html .= '<a style="display:none" href="/public/' . $dir . '/' . $img . '" title="' . $img . '" class="js-img-viwer" data-group="format">';
          $html .= '<img src="/public/' . $dir . '/' . $img . '">';
          $html .= '</a>';
        }

      }
    }

    return $html;
  }


  private function gallery($images, $count)
  {

    $html = null;

    $i = 0;

    foreach ($images as $img) {

      $i++;

      $img = $img['img'];

      if ($i > $count) {

        $html .= '<a style="display: none" href="/public/images/gallery/' . $img . '" title="' . $img . '" class="js-img-viwer" data-group="view">';
        $html .= '<img src="/public/images/gallery/min/' . $img . '">';
        $html .= '</a>';

      } else {

        $html .= '<a href="/public/images/gallery/' . $img . '" title="' . $img . '" class="js-img-viwer" data-group="view">';
        $html .= '<img src="/public/images/gallery/min/' . $img . '">';
        $html .= '</a>';

      }


    }

    return $html;

  }

}