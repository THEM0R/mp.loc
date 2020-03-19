<?php

namespace app\controllers;

use lib\App;
use Spatie\Image\Image;

class GalleryController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {

    $title = 'Галерея ' . '|' . $this->title;

    $this->meta($title);

    $images = $this->getImages();

    $this->render(compact('images'));
  }


  private function getImages()
  {

    $html = null;

    $i = 0;

    foreach (scandir(CONTENT . 'images/gallery', 1) as $img) {

      $i++;

      //if($i < 29) {

      $dir = CONTENT . 'images/gallery/' . $img;
      $dir2 = CONTENT . 'images/gallery/min/' . $img;

      if (is_file($dir)) {

        //$name = explode('.',$img)[0];
//                    $gallery = \R::xDispense('_gallerys');
//                    $gallery->img   = $img;
//                    $gallery->type  = 1;
//                    \R::store($gallery);

        //                Image::load( $dir )
        //                    //->crop(Manipulations::CROP_TOP, 300, 400)
        //                    ->width(300)
        //                    //->height(250)
        //                    ->quality(80)
        //                    ->optimize()
        //                    ->save($dir2);

        //$width = getimagesize($dir)[0];
        //$height = getimagesize($dir)[1];

        //Image::load( $dir )->width(1200)->optimize()->save();


        $html .= '<!-- photo -->';
        $html .= '<a href="/public/images/gallery/' . $img . '" title="' . $img;
        $html .= '" class="photo js-img-viwer" data-group="view">';
        $html .= '<img class="poster" src="/public/images/gallery/min/' . $img . '">';
        $html .= '</a><!-- photo end -->';

      }


      //}

    }

    return $html;

  }
}