<?php


namespace app\controllers;

use lib\App;

class PageController extends AppController
{

  public function indexAction($model, $route)
  {


    $page = \R::getRow('SELECT * FROM _pages WHERE url = ? AND active = ?', [$route['page'], 1]);

    if (!$page) {
      App::notFound();
    }

    $title = $page['name'] . ' |' . $this->title;

    $this->meta($title);

    $this->render(compact('page'));
  }
}