<?php

namespace app\controllers;

use lib\App;

class AboutController extends AppController
{

  public $title = 'Про нас | Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {

    $this->meta($this->title);

    $gallery = $this->gallery(\R::getAll('SELECT * FROM _gallery WHERE type = 77'));


    $this->render(compact( 'gallery'));


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
}