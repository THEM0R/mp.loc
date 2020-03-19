<?php

namespace app\controllers;

use lib\App;

class MainController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {

    $title = 'МЕТАЛІК-PLUS |' . $this->title;

    $this->meta($title, $this->configs['about']['description'] . ' ' . $this->keywords());

    $products = \R::getAll('SELECT id,name,url FROM _material WHERE active = 1');

    //pr1($products);

    $slider = $this->slider(\R::getAll('SELECT * FROM _material WHERE active = 1 AND slider = 1'));

    $gallery = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = 77'));

    $this->render(compact('products', 'slider', 'gallery'));

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
      $html .= '<p class="description">' . $item['info'] . '</p>';
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