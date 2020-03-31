<?php

namespace app\controllers;

use lib\App;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use function GuzzleHttp\Psr7\str;

class AdminController extends AppController
{

  public $title = ' | Адмін Панель - MetallicPlus.Com.Ua';

  public function indexAction($model, $route)
  {

    $title = 'Головна';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    /*
     * articles
     */
    $articles = \R::getAll('SELECT * FROM _articles WHERE active = ?', [1]);


    $this->render(compact('title', 'description', 'articles'));


  }

  /*
   * category
   */

  public function categoryAction($model, $route)
  {
    $title = 'Категорії';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    $category = \R::getAll('SELECT * FROM _category');


    $this->render(compact('title', 'description', 'category'));
  }

  public function categoryAddAction($model, $route)
  {

    if (isset($_POST['category_add'])) {

      $name = (string)$_POST['name'];
      $url = (string)$_POST['url'];
      $description = (string)$_POST['description'];

      if (!empty($name)) {
        $count = \R::count('_category', 'WHERE name = ?', [$name]);
        if ($count > 0) {
          $_SESSION['cat_add']['error'] = 'Така Категорія вже існує!';
          App::redirect('/admin/category/add');
        }

        $cat = \R::xDispense('_category');
        $cat->name = $name;
        $cat->url = $url;
        $cat->description = $description;

        if (\R::store($cat)) {
          $_SESSION['cat_add']['success'] = 'Категорія успішно добавлена!';
          App::redirect('/admin/category');
        }
      }

    }

    $title = 'Добавлення Категорії';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    $category = \R::getAll('SELECT * FROM _category');


    $this->render(compact('title', 'description', 'category'));
  }

  public function categoryEditAction($model, $route)
  {
    if (isset($_POST['category_edit'])) {

      $id = (int)$_POST['id'];
      $name = (string)$_POST['name'];
      $url = (string)$_POST['url'];
      $description = (string)$_POST['description'];


      if (!empty($name)) {

        $cat = \R::findOne('_category', 'WHERE id = ?', [$id]);

        $cat->name = $name;
        $cat->url = $url;
        $cat->description = $description;

        if (\R::store($cat)) {
          $_SESSION['cat_add']['success'] = 'Категорія успішно оновлена!';
          App::redirect('/admin/category');
        }
      }

    }

    $title = 'Редагування Категорії';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];

    $category = \R::getRow('SELECT * FROM _category WHERE id = ?', [$route['id']]);

    $this->render(compact('title', 'description', 'category'));
  }

  public function categoryDeleteAction($model, $route)
  {
    $category = \R::load('_category', $route['id']);
    \R::trash($category);
    $_SESSION['cat_add']['success'] = 'Категорія успішно видалена!';
    App::redirect('/admin/category');

  }

  /*
   * articles
   */

  public function articlesAction($model, $route)
  {

    $title = 'Матеріали';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat) {
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $articles = \R::getAll('SELECT * FROM _articles');


    $this->render(compact('title', 'description', 'category', 'articles'));
  }

  public function articlesViewAction($model, $route)
  {

    $title = 'Матеріал';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat) {
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $article = \R::getRow('SELECT * FROM _articles WHERE id = ? AND active = ?', [$route['id'], 1]);

    $this->render(compact('title', 'description', 'category', 'article'));
  }


  public function articlesAddAction($model, $route)
  {


    if (isset($_POST['articles_add'])) {

      //pr1($_POST);

      if (!empty($_POST['name'])) {

        $count = \R::count('_articles', 'WHERE name = ?', [$_POST['name']]);

        if ($count > 0) {
          $_SESSION['articles_add']['error'] = 'Такий Матеріал вже існує!';
          App::redirect('/admin/articles/add');
        }


        $article = \R::xDispense('_articles');

        $article = $this->articlesArray($article, $_POST);

        if ($article) {

          $_SESSION['articles_add']['success'] = 'Матеріал успішно добавлений!';
          App::redirect('/admin/articles');
        }
      }

    }

    $title = 'Добавлення Матеріалу';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat) {
      $category[$cat['id']] = $cat;
    }

    $this->render(compact('title', 'description', 'category'));
  }

  private static function addScreens($screens)
  {

    if (isset($screens) and $screens != []) {

      $screens = (array)$screens;

      $_screens = [];

      foreach ($screens as $screen) {

        if ($screen['data-type'] == 'base64') {

          $_screens[] = App::Base64ImageUpload($screen['image'], UPL_ART_SCR);

        } elseif ($screen['data-type'] == 'image') {

        }
      }

      $_screens_str = '';
      foreach ($_screens as $item) {
        $_screens_str .= $item . '|';
      }

      return rtrim($_screens_str, '|');


    } else {
      return NULL;
    }

  }

  private static function addPoster($poster, $data)
  {

    if (isset($data['poster']) and $data['poster'] != '') {

      if ($data['poster-data-type'] == 'base64') {
        $_poster = App::Base64ImageUpload($data['poster'], UPL_ART);
      } else if ($data['poster-data-type'] == 'image') {
        if ($poster == $data['poster']) {
          $_poster = $data['poster'];
        }
        //upload poster
      }

      return $_poster;

    }
    return NULL;
  }

  private static function addDrawing($data){

    if (isset($data['drawing']) and $data['drawing'] === '') {

      if ($data['drawing-data-type'] == 'base64') {
        $drawing = App::Base64ImageUpload($data['drawing'], UPL_DRA);
      } else if ($data['drawing-data-type'] == 'image') {
        // upload image
      }
    } else {
      $drawing = NULL;
    }

    return $drawing;

  }


  private function articlesArray($article, $data)
  {

    $article->name = $data['name'];
    $article->alt_name = $data['alt_name'];
    $article->category = $data['category'];
    $article->url = $data['url'];
    $article->description = $data['description'];
    $article->views = 0;

    // poster
    $article->poster = self::addPoster($article->poster, $data);
    // drawing
    $article->drawing = self::addDrawing($data);
    // screens
    $article->screens = self::addScreens($data['screens']);


    if (isset($data['active']) and $data['active'] === 'on') {
      $data['active'] = 1;
    } else {
      $data['active'] = 0;
    }
    $article->active = $data['active'];

    if (\R::store($article)) {
      return true;
    }
    return false;
  }

  public function articlesEditAction($model, $route)
  {

    if (isset($_POST['articles_edit'])) {

      if (!empty($_POST['name'])) {

        $article = \R::findOne('_articles', 'WHERE id = ?', [$_POST['id']]);

        $article = $this->articlesArray($article, $_POST);

        if ($article) {
          $_SESSION['articles_add']['success'] = 'Категорія успішно оновлена!';
          App::redirect('/admin/articles');
        }
      }
    }


    $title = 'Редагування Матеріалу';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $category = [];
    foreach (\R::getAll('SELECT * FROM _category') as $cat) {
      $category[$cat['id']] = $cat;
    }

    //pr1($category);

    $article = \R::getRow('SELECT * FROM _articles WHERE id = ? AND active = ?', [$route['id'], 1]);

    $this->render(compact('title', 'category', 'article'));
  }

  public function articlesDeleteAction($model, $route)
  {
    $article = \R::load('_articles', $route['id']);
    \R::trash($article);
    $_SESSION['articles_add']['success'] = 'Матеріал успішно видалений!';
    App::redirect('/admin/articles');
  }


  /*
   * page
   */
  public function pageAction($model, $route)
  {

    $title = 'Сторінки';
    $this->meta($title . $this->title);
    $this->theme = 'admin';
    /*
     * pages
     */
    $pages = \R::getAll('SELECT * FROM _pages WHERE active = ?', [1]);
    $this->render(compact('title', 'pages'));
  }

  public function pageViewAction($model, $route)
  {


    /*
     * pages
     */
    $page = \R::getRow('SELECT * FROM _pages WHERE id = ? AND active = ?', [$route['id'], 1]);

    $title = $page['name'];

    $this->meta($title . $this->title);
    $this->theme = 'admin';

    $this->render(compact('title', 'description', 'page'));
  }

  public function pageAddAction($model, $route)
  {

    if (isset($_POST['page_add'])) {

      $name = (string)$_POST['name'];
      $url = (string)$_POST['url'];
      $description = (string)$_POST['description'];

      if (!empty($name)) {
        $count = \R::count('_pages', 'WHERE name = ?', [$name]);
        if ($count > 0) {
          $_SESSION['page_add']['error'] = 'Така Сторінка вже існує!';
          App::redirect('/admin/page/add');
        }

        $cat = \R::xDispense('_pages');
        $cat->name = $name;
        $cat->url = $url;
        $cat->description = $description;

        if (\R::store($cat)) {
          $_SESSION['page_add']['success'] = 'Сторінка успішно добавлена!';
          App::redirect('/admin/page');
        }
      }

    }

    $title = 'Добавлення Сторінки';
    $this->meta($title . $this->title);
    $this->theme = 'admin';
    /*
     * pages
     */
    $page = \R::getAll('SELECT * FROM _pages WHERE active = ?', [1]);
    $this->render(compact('title', 'description', 'page'));
  }

  public function pageEditAction($model, $route)
  {

    if (isset($_POST['page_edit'])) {

      $id = (int)$_POST['id'];
      $name = (string)$_POST['name'];
      $url = (string)$_POST['url'];
      $description = (string)$_POST['description'];


      if (!empty($name)) {

        $cat = \R::findOne('_pages', 'WHERE id = ?', [$id]);

        $cat->name = $name;
        $cat->url = $url;
        $cat->description = $description;

        if (\R::store($cat)) {
          $_SESSION['page_add']['success'] = 'Сторінка успішно оновлена!';
          App::redirect('/admin/page');
        }
      }

    }

    $title = 'Редагування Сторінки';
    $this->meta($title . $this->title);
    $this->theme = 'admin';
    /*
     * pages
     */
    $page = \R::getRow('SELECT * FROM _pages WHERE id = ? AND active = ?', [$route['id'], 1]);
    $this->render(compact('title', 'description', 'page'));
  }

  public function pageDeleteAction($model, $route)
  {
    $page = \R::load('_pages', $route['id']);
    \R::trash($page);
    $_SESSION['page_add']['success'] = 'Сторінка успішно видалена!';
    App::redirect('/admin/page');
  }


  /*
   * widgets
   */

  public function widgetsAction($model, $route)
  {
    $title = 'Віджети';

    $this->meta($title . $this->title);

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _widgets');
    $count = \R::count('_widgets');


    $this->render(compact('title', 'description', 'category', 'count'));
  }


  public function widgetsAddAction($model, $route)
  {

    if (isset($_POST['add_widget'])) {

      $name = (string)$_POST['name'];
      $position = (int)$_POST['position_sidebar'];
      $url = (string)$_POST['url'];

      if (!empty($url)) {

        $widget = \R::xDispense('_widgets');

        $widget->name = $name;
        $widget->position_sidebar = $position;
        $widget->url = $url;

        if (\R::store($widget)) {
          App::redirect('/admin/widgets');
        }

      }

    }

    $this->meta();

    $this->theme = 'admin';

    $description = $this->configs['about']['description2'];


    $category = \R::getAll('SELECT * FROM _widgets');
    $count = \R::count('_widgets');


    $this->render(compact('title', 'description', 'category', 'count'));
  }


}