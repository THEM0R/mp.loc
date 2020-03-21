<?php


namespace app\controllers;

use lib\App;

class UploadController extends AppController
{
  public function urlAction($model, $route)
  {
    if (App::is_Post()) {

      if (isset($_POST['url'])) {

        if (!empty($_POST['url'])) {

          $img = trim($_POST['url']);

          $filetype = '';

          $getMime = explode('.', $img);
          $mime = end($getMime);

          if (in_array($mime, ['png', 'jpg', 'jpeg', 'webp', 'gif'])) {

            if ($mime == 'jpg') {

              $filetype = '/jpeg';

            } elseif ($mime == 'jpeg') {

              $filetype = '/jpeg';

            } elseif ($mime == 'png') {

              $filetype = '/png';
            } elseif ($mime == 'webp') {

              $filetype = '/webp';
            } elseif ($mime == 'gif') {

              $filetype = '/gif';
            }

            $base64 = 'data:image' . $filetype . ';base64,' . base64_encode(file_get_contents($img));

            exit(json_encode(['type' => 'success', 'data' => $base64, 'file_type' => $filetype]));
          } else {
            exit(json_encode(['type' => 'error', 'data' => 'Недопустимый формат файла!!!']));
          }


        }

      }

    }
    /*
     * articles
     */
    $articles = \R::getAll('SELECT * FROM _articles WHERE active = ?', [1]);

  }
}
