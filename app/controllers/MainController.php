<?php

namespace app\controllers;

use lib\App;

class MainController extends AppController
{


  public function indexAction($model, $route)
  {

    $title = 'МЕТАЛІК-PLUS |' . $this->title;

    $this->meta($title);

    $products = \R::getAll('SELECT id,name,url FROM _material WHERE active = 1');

    //pr1($products);

    $slider = \R::getAll('SELECT * FROM _articles WHERE active = 1 AND slider = 1');

    $gallery = \R::getAll('SELECT * FROM _gallery WHERE type = ? LIMIT ?', [1, 10]);

    $about = \R::getRow('SELECT * FROM _pages WHERE url = ? AND active = ?', ['about', 1]);

    $this->render(compact(
      'products',
      'slider',
      'gallery',
      'about'
    ));

  }

  private function gallery($images)
  {

    $html = null;

    foreach ($images as $img) {

      $img = $img['img'];

      $html .= '<!-- photo -->';
      $html .= '<a href="/public/images/gallery/' . $img . '" title="' . $img;
      $html .= '" class="photo js-img-viwer" data-group="view">';
      $html .= '<img class="poster" src="/public/images/gallery/min/' . $img . '">';
      $html .= '</a><!-- photo end -->';


    }

    return $html;

  }

  private function slider($data)
  {

    $html = '<div class="slider-main"><ul class="rslides">';

    foreach ($data as $item) {

      $html .= '<li><a href="' . $item['url'] . '">';
      $html .= '<div class="img" alt="" style="background-image: url(/public/images/slider/bg/' . $item['id'] . '.jpg)">';
      $html .= '<!-- content --><div class="content">';
      $html .= '<h3 class="name">' . $item['name'] . '</h3>';
      $html .= '<h1 class="alt_name">Металевий</h1>';
      $html .= '<p class="description">' . $item['description'] . '</p>';
      $html .= '<img class="slider-logo" src="/public/images/articles/material/' . $item['id'] . '.png" alt="">';
      $html .= '</div><!-- content --></div></a></li>';

    }

    $html .= '</ul></div>';

    return $html;

  }


  public function praisAction($model, $route)
  {
    $title = 'Прайс лист |' . $this->title;

    $this->meta($title);

    $move = [];

    $this->render(compact('move'));
  }


}