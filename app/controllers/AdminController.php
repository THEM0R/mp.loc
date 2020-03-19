<?php

namespace app\controllers;

use lib\App;
use function GuzzleHttp\Psr7\str;

class AdminController extends AppController
{

  public $title = ' | Адмін Панель - MetallicPlus.Com.Ua';

  public function indexAction($model, $route)
  {

    $title = 'Головна';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    /*
     * articles
     */
    $articles = \R::getAll('SELECT * FROM _articles WHERE active = ?',[1]);


    $this->render(compact('title','description','articles'));


  }

  public function categoryAction($model, $route)
  {
    $title = 'Категорії';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    $category = \R::getAll('SELECT * FROM _category');


    $this->render(compact('title','description','category'));
  }

  public function articlesAction($model, $route)
  {

    $title = 'Матеріали';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat){
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $articles = \R::getAll('SELECT * FROM _articles WHERE active = ?', [1]);


    $this->render(compact('title','description','category','articles'));
  }
  public function articlesViewAction($model, $route)
  {

    $title = 'Матеріал';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat){
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $article = \R::getRow('SELECT * FROM _articles WHERE id = ? AND active = ?', [$route['id'],1]);

    $this->render(compact('title','description','category','article'));
  }
  public function articlesEditAction($model, $route)
  {

    $title = 'Редагування Матеріалу';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat){
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $article = \R::getRow('SELECT * FROM _articles WHERE id = ? AND active = ?', [$route['id'],1]);

    $this->render(compact('title','description','category','article'));
  }

  public function widgetsAction($model, $route)
  {
    $title = 'Віджети';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _widgets');
    $count = \R::count('_widgets');


    $this->render(compact('title','description','category','count'));
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


    $this->render(compact('title','description','category','count'));
  }


  public function pageAction($model, $route)
  {

    $title = 'Сторінки';

    $this->meta($title.$this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    /*
     * articles
     */
    $articles = \R::getAll('SELECT * FROM _articles WHERE active = ?',[1]);


    $this->render(compact('title','description','articles'));


  }



}