<?php

namespace app\controllers;

use DateTime;
use mvc\Controller, lib\App, lib\Map;

class AppController extends Controller
{

  // app controller

  public function __construct($model, $route)
  {
    parent::__construct($model, $route);


    // Admin redirect
    if ($route['controller'] == 'Admin') {
      if ($route['action'] != 'auth') {
        if (!isset($_SESSION['admin']['auth'])) {
          App::redirect('/admin/auth');
        }
      }
    }

    //pr($route);

  }
}