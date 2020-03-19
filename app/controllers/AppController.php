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
    
    //pr($route);
  }
}