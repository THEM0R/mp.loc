<?php

namespace mvc;

use DateTime;
use lang\Language;
use core\DB;
use lib\App;


abstract class Controller
{

  public $meta = [];

  /*
   * @array $route
   * текущий маршрут
   */
  public $route = null;
  public $controller = null;

  /*
   * @var $view
   * текущий вид
   */
  public $view = null;

  /*
   * @var $templates
   * текущий шаблон
   */
  public $theme = null;

  /*
   * @array $templates
   */
  public $vars = null;

  public $rb;


  public $configs = [

    'menu' => [
      1 => [
        'url' => '',
        'name' => 'Головна'
      ],
      2 => [
        'url' => 'material',
        'name' => 'Матеріали'
      ],
      3 => [
        'url' => 'metal',
        'name' => 'Металопрокат'
      ],
      4 => [
        'url' => 'gallery',
        'name' => 'Галерея'
      ],
      5 => [
        'url' => 'page/about',
        'name' => 'Про нас'
      ],
//            5 => [
//                'url' => 'contact',
//                'name' => 'Контакти'
//            ],
    ],

    'about' => [

      'title' => 'ПРО НАС',

      'description2' => 'Приватне підприємство «Металік-Плюс»<br>
        займається виробництвом:<br>
        блок-хаусу<br>
        евро-брусу<br>
        металочерепиці<br>
        профнастилу<br>
        металоштахетника та аксесуарів для даху.<br>
        Виконуємо комплектацію стандартних та індивідуальних розмірів.<br>
        <div class="probel"></div>
        Завод «Металік-Плюс» знаходиться в місті Калуш, Івано-Франківської області.
        <br><br>Початок діяльності було покладено в 2007 році.<br>
        
        За 12 років свого існування фірма змогла завоювати довіру своїх клієнтів.
        <br>«Металік-Плюс» знають і поважають в Україні!.<br><br>
        
        Швидкість виконання роботи, 
        індивідуальний підхід та оптимальні ціни - це те,
        <br>що робить продукцію заводу привабливою та вигідною для покупців!',

      'iframe' => '<iframe src="https://www.youtube.com/embed/pWFv_BZ3gb0?autoplay=0&showinfo=0&controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
    ],


  ];


  public $categories = [];
  public $articles = [];
  public $settings = [];

  public $menu = [];
  public $title = '';


  public function __construct($model, $route)
  {

    $this->rb = DB::instance();

    // route
    $this->route = $route;

    $this->controller = App::lowerCamelCase($route['controller']);
    $this->view = $route['view'];
    // Language
    // theme
    if (!$this->theme) $this->theme = THEME;

    //pr1($this->configs);


    $this->categories['assoc'] = \R::getAssoc('SELECT * FROM _category');
    $this->categories['array'] = \R::getAll('SELECT * FROM _category');
    $this->articles = \R::getAll('SELECT * FROM _articles WHERE active = 1');


    $this->settings = \R::getRow('SELECT * FROM _settings');

    $this->menu[0]['url'] = ['/'];
    $this->menu[0]['name'] = ['Головна'];

    $this->title = ' ' . $this->settings['sitename'];

    //pr1($this->categories);


    ///
    ///

//    $images = \R::getAll('SELECT id,screens FROM _articles');
//
//    $image = [];
//
//    foreach ($images as $item) {
//      if ($item['screens'] != '') {
//        $image[$item['id']] = explode('|', $item['screens']);
//      }
//    }
//    foreach ($image as $k => $v) {
//      foreach ($v as $item) {
//        $gallery = \R::xDispense('_gallery');
//        $gallery->type = 1;
//        $gallery->img = $item;
//        $gallery->article = $k;
//        \R::store($gallery);
//      }
//    }



  }


  public function getView()
  {
    $viewObject = new View($this->route, $this->theme, $this->view, $this->meta);

    if (is_dir(APP . '/views/' . $this->theme . '/')) {
      $theme = APP . '/views/' . $this->theme . '/';
    } else {
      $theme = null;
    }


    $configs = $this->configs;

    $meta = $this->meta;
    $route = $this->route;
    $controller = $this->controller;

    // $this->categories

    $categories = $this->categories;
    $articles = $this->articles;

    $settings = $this->settings;


    $md = \R::getAll('SELECT * FROM _module');
    $modules = [];

    //foreach ($md as $m) {
    //    $module[$m['position']] = $m['html'];
    //}

    foreach ($md as $m) {

      if ($m['controller'] == 'all') {

        //pr1($theme . 'module/' . $m['position'] . '.html');

        if (is_file($theme . 'module/' . $m['position'] . '.html')) {
          $modules[$m['position']] = $theme . 'module/' . $m['position'] . '.html';
        } else {
          $modules[$m['position']] = false;
        }
      } else if ($m['controller'] == $controller) {
        if (is_file($theme . 'module/' . $m['position'] . '.html')) {
          $modules[$m['position']] = $theme . 'module/' . $m['position'] . '.html';
        } else {
          $modules[$m['position']] = false;
        }
      }
    }

    //pr1($module);


    $all = compact(
      'theme',
      'route',
      'meta',
      'configs',
      'controller',
      'modules',
      'categories',
      'articles',
      'settings'
    );

    if ($this->vars) {
      $array = array_merge($all, $this->vars);
    } else {
      $array = $all;
    }


    // unset optimize
    unset($theme);
    unset($meta);
    unset($route);
    unset($all);


    $viewObject->rendering($array);

    // unset optimize
    unset($viewObject);
    unset($array);
  }

  public function render($vars = null)
  {
    $this->vars = $vars;

    // unset optimize
    unset($vars);
  }

  public function Meta($title = null, $description = null, $keywords = null)
  {

    //pr1($this->settings['meta_title']);

    $this->meta['title'] = $title ?: $this->settings['meta_title'];
    $this->meta['keywords'] = $keywords ?: $this->keywords();
    $this->meta['description'] = $description ?: $this->settings['meta_description'];

    // unset optimize
    unset($title);
    unset($keywords);
    unset($description);
  }

  public function keywords()
  {

    $string = '';

    $product = $this->settings['meta_keywords_product'] . ', ';
    $sity = $this->settings['meta_keywords_sity'] . ', ';

    foreach (explode(', ', $sity) as $sity) {

      foreach (explode(', ', $product) as $tiem) {
        $string .= $sity . ' ' . $tiem . ', ';
      }


    }

    return rtrim($string, ', ');

  }


}