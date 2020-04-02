<?php


namespace app\controllers;

use lib\App;

class PageController extends AppController
{

  public $title = ' Приватне Підприємство МЕТАЛІК-PLUS';


  public function indexAction($model, $route)
  {
    $title = 'МЕТАЛІК-PLUS |' . $this->title;

    $this->meta($title);

    $page = \R::getRow('SELECT * FROM _pages WHERE url = ? AND active = ?', [$route['page'], 1]);

    if (!$page) {
      App::notFound();
    }

    $this->render(compact('page'));
  }
}