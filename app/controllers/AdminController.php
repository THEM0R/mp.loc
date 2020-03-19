<?php

namespace app\controllers;

use lib\App;
use function GuzzleHttp\Psr7\str;

class AdminController extends AppController
{

  public function indexAction($model, $route)
  {

    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    $this->render(compact('description'));


  }

  public function categoryAction($model, $route)
  {
    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $_category = \R::getAll('SELECT * FROM _category');

    $parent_category = [];
    $category = [];

    foreach ($_category as $cat){
      if($cat['parent_category'] == 0){
        $parent_category[] = $cat;
      }
    }

    foreach ($parent_category as $cts){

      foreach ($_category as $cat){
        if($cat['parent_category'] == $cts['id']){
          $cts['parents'][] = $cat;
        }
      }

      $category[] = $cts;

    }

    $this->render(compact('description','category'));
  }

  public function productAction($model, $route)
  {
    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _category');


    $this->render(compact('description','category'));
  }

  public function widgetsAction($model, $route)
  {
    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _widgets');
    $count = \R::count('_widgets');


    $this->render(compact('description','category','count'));
  }


  public function widgetsAddAction($model, $route)
  {

    if(isset($_POST['add_widget'])){

      $name = (string)$_POST['name'];
      $position = (int)$_POST['position_sidebar'];
      $url = (string)$_POST['url'];

      if(!empty($url)){

        $widget = \R::xDispense( '_widgets' );

        $widget->name = $name;
        $widget->position_sidebar = $position;
        $widget->url = $url;

        if(\R::store($widget)){
          App::redirect('/admin/widgets');
        }

      }

    }

    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _widgets');
    $count = \R::count('_widgets');


    $this->render(compact('description','category','count'));
  }



}