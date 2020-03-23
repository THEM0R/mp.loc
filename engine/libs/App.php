<?

namespace lib;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Statickidz\GoogleTranslate;
use Translator;

class App
{


  public static $config = [

    'script' => [
      'main' => [

      ],
      'all' => [
        'html' => [
          'speed.search',
          'action',
          'auth',

        ],
        'js' => [
          'change.language',
          'article'
        ]
      ],
      'libs' => [
        'jquery',
        'carusell',
        'responsiveHub',
        'transforms3d',
        'scrollfix',
        'slider',
        'gallery',
        'sumoselect',
        'textarea',
        'chosen',
        'modal',
        'nicescroll',
        'icheck',
        'croppie',
        'tagsinput',
        'noty',
      ],
    ],

    'pattern' => [
      'login' => '([-_.a-zA-Z0-9]){3,16}',
      'email' => '([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+',
    ],

    'sorting' => [
      1 => 'Сортировать по',
      2 => 'Просмотрам',
      3 => 'Дате добавления',
      4 => 'Рейтингу'
    ],

    'image_valid' => ['png', 'jpg', 'jpeg'],

    'lang_select' => [
      1 => 'RU',
      2 => 'UA',
      3 => 'EN'
    ],

    'player_voice' => [

      1 => 'Дублированный',
      2 => 'Профессиональный',
      3 => 'Любительский',
      4 => 'Авторский',
      5 => 'Оригинал'
    ],

    'player_quality' => [

      1 => '1080',
      2 => '720',
      3 => '480',
      4 => '360'
    ],

    'age' => [

      1 => 0,
      2 => 6,
      3 => 12,
      4 => 16,
      5 => 18
    ],

    'category' => [
      1 => [
        'id' => 1,
        'name' => 'Фильмы',
        'url' => 'film'
      ],
      2 => [
        'id' => 2,
        'name' => 'Сериалы',
        'url' => 'series'
      ],
      3 => [
        'id' => 3,
        'name' => 'Мультфильмы',
        'url' => 'cartoons'
      ],
      4 => [
        'name' => 'Новинки',
        'url' => 'news'
      ],
    ],

  ];

  public static function imageUpload($image, $folder)
  {
    if (!empty($image)) {
      //code

      // Получаем расширение файла
      $mime = 'jpg'; // webp

      // Выделим данные
      $data = explode(',', $image);

      // Декодируем данные, закодированные алгоритмом MIME base64
      $encodedData = str_replace(' ', '+', $data[1]);
      $decodedData = base64_decode($encodedData);

      // Вы можете использовать данное имя файла, или создать произвольное имя.
      // Мы будем создавать произвольное имя!
      $random = substr_replace(sha1(microtime(true)), '', 12);
      $randomName = $random . '.' . $mime;

      // Создадим папку если её нет
      if (!is_dir($folder)) if (!mkdir($folder)) exit('не удалось создать папку');
      if (!chmod($folder, 0777)) exit ('не удалось задать права 0777');

      // Создаем изображение на сервере
      if (file_put_contents($folder . '/' . $randomName, $decodedData)) {

        // https://docs.spatie.be/image/v1/usage/saving-images/#saving-in-a-different-image-format
        Image::load($folder . '/' . $randomName)
          ->format(Manipulations::FORMAT_WEBP)
          ->optimize()
          ->save($folder . '/' . $random . '.webp');

        // видаляєм файл
        unlink($folder . '/' . $randomName);

        $image = $random . '.webp';

      } else {
        // error
        $image = false;
      }

    } else {
      // poster not found
      $image = false;
    }

    return $image;
  }

  public static function RandomString($length)
  {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);

  }

  public static function sendMail($link, $email, $login, $recovery_hash, $theme, $message, $loss_submit)
  {

    // message
    $message = self::mailHtml($link, $email, $login, $recovery_hash, $message, $loss_submit);

    // message end

//                $message = $this->language['auth']['loss'].' Паролю '.$value. "\r\n" .
//                '<form method="post"></form>';

    $headers = 'From: admin@mor.cx' . "\r\n" .
      'Reply-To: admin@mor.cx' . "\r\n" .
      'Content-type: text/html' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

    if (mail($email, $theme, $message, $headers)) {
      return true;
    }
    return false;

  }

  private static function mailHtml($link, $email, $login, $recovery_hash, $text, $loss_submit)
  {

    $message = require ENGINE . 'mail/head.html';
    // header end


    $message .= '<div class="content">';
    //$message .=  '<span class="preheader"><!--This is preheader text. Some clients will show this text as a preview.--></span>';
    $message .= '<table role="presentation" class="main">';
    $message .= '<tr><td class="wrapper"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td>';
    $message .= '<p class="login"><b>' . $login . '</b></p>';
    $message .= $text;
    $message .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left">';
    $message .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';

    $message .= '<tbody><tr>';

    $message .= '<td> <form method="post" action="' . $link . '"><input style="display:none" type="hidden" name="email" value="' . $email . '"><input style="display:none" type="hidden" name="hash" value="' . $recovery_hash . '"><button type="submit" name="recovery-password" class="btn">' . $loss_submit . '</button></form> </td>';
    $message .= '</tr></tbody>';

    $message .= '</table></td></tr></tbody></table>';
    //$message .=  '<p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>';
    //$message .=  '<p>Good luck! Hope it works.</p>';
    $message .= '</td></tr></table></td></tr></table></div>';


    // footer
    $message .= require ENGINE . 'mail/footer.html';

    return $message;

  }

  public static function strf_time($format, $data)
  {

    $locale = LOCAL_TIME;

    $date_str = strftime($format, $data);

    if (strpos($locale, '1251') !== false) {
      return iconv('cp1251', 'utf-8', $date_str);
    } else {
      return $date_str;
    }
  }


  public static function require_pro($file)
  {
    if (is_file($file)) return require($file);
  }


  public static function var_name()
  {
    // read backtrace
    $bt = debug_backtrace();
    // read file
    $file = file($bt[0]['file']);
    // select exact debug($varname) line
    $src = $file[$bt[0]['line'] - 1];
    // search pattern
    $pat = '#(.*)' . __FUNCTION__ . ' *?\( *?(.*) *?\)(.*)#i';
    // extract $varname from match no 2
    $var = preg_replace($pat, '$2', $src);
    // print to browser
    $var = str_replace(')', '', $var);
    $var = str_replace('$', '', $var);
    echo trim($var);
  }

  public static function setUser($data)
  {
    $_SESSION[AUTH] = $data;
  }

  public static function showMessage($type, $text)
  {

    $_SESSION[ACTION]['type'] = $type;
    $_SESSION[ACTION]['text'] = $text;

  }

  public static function notFound($text = null)
  {
    http_response_code(404);

    $return = '<p style="margin-top:80px;margin-left:40px;font-size:55px;font-width:bold">';

    if ($text != null) {
      $return .= $text;
    } else {
      $return .= '404 Сторінку не знайдено!';
    }

    $return .= '<br> <a style="font-size: 24px;color: red" href="/">Перейти на головну</a>';
    $return .= '</p>';

    exit($return);
  }

  public static function upperCamelCase($name)
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
  }

  public static function lowerCamelCase($name)
  {
    return lcfirst(self::upperCamelCase($name));
  }

  /**
   * @return bool
   */
  public static function is_Ajax()
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  }

  /**
   * @return bool
   */
  public static function is_Post()
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  /**
   * @return bool
   */
  public static function is_Get()
  {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  public static function validString($string, $pattern)
  {
    return !preg_match('/^' . $pattern . '$/', $string);
  }

  public static function ValidInput($input, $string)
  {

    $input = trim($input);

    return [
      'pattern' => self::validString($input, self::$config['pattern'][$string]),
      'freedom' => \R::count('_user', $string . "  = ?", [$input]),
    ];
  }

  public static function redirect($http = false)
  {

    if ($http) $redirect = $http;
    else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : DOMEN;
    header("Location: $redirect");
    exit;
  }

  public static function sendResponseEcho($type, $data)
  {

    if ($data == '') {
      echo json_encode(['type' => $type]);
    } else {
      echo json_encode(['type' => $type, 'data' => $data]);
    }
  }

  public static function Response($type, $data = null, $value = null)
  {

    if (!$data) {
      exit(json_encode(['type' => $type]));
    } else {
      exit(json_encode(['type' => $type, 'data' => $data, 'value' => $value]));
    }
  }


  // translate

  public static function Ua($name)
  {

    $first = mb_substr($name, 0, 1, "UTF-8");
    $next = mb_substr($name, 1, 500, "UTF-8");


    $array = ['#', '"', '«', '('];

    if (in_array($first, $array)) {

      return $name;
    }

    if (is_numeric($first)) {

      return $name;
    }

    $arr = [
      'а' => 'А', 'б' => 'Б',
      'в' => 'В', 'г' => 'Г',
      'ґ' => 'Ґ', 'д' => 'Д',
      'е' => 'Е', 'є' => 'Є',
      'ж' => 'Ж', 'з' => 'З',
      'и' => 'И', 'і' => 'І',
      'ї' => 'Ї', 'й' => 'Й',
      'к' => 'К', 'л' => 'Л',
      'м' => 'М', 'н' => 'Н',
      'о' => 'О', 'п' => 'П',
      'р' => 'Р', 'с' => 'С',
      'т' => 'Т', 'у' => 'У',
      'ф' => 'Ф', 'х' => 'Х',
      'ц' => 'Ц', 'ч' => 'Ч',
      'ш' => 'Ш', 'щ' => 'Щ',
      'ь' => 'Ь', 'ю' => 'Ю',
      'я' => 'Я',
    ];

    $string = '';

    //Узнаю какой регистр

    if (mb_strtolower($first, 'utf-8') != $first) {

      return $name;

    } else {

      foreach ($arr as $k => $v) {

        if ($k == $first) {

          $string .= $v . $next;

        }
      }

      return $string;
    }


  }

  public static function translate($text)
  {

    $google = self::google_translate($text);

    if ($google == false) {

      $yandex = self::yandex_translate($text);

      if ($yandex == false) {

        return false;

      } else {

        return $yandex;

      }

    } else {

      return $google;

    }
  }

  public static function yandex_translate($text)
  {

    try {

      $key = 'trnsl.1.1.20180912T200326Z.57cfd7762d891bd8.a10936a4ff9bb24f6e73587c7f74fbe3e6f30920';

      $translator = new Translator($key);

      $translation = $translator->translate($text, 'en-uk');

      $result = $translation->getResult()[0];
      if ($result == '') {
        return false;
      } else {
        return $result;
      }
    } catch (Exception $e) {

      return false;
    }


  }

  public static function google_translate($text)
  {

    //require 'google.translate.class.php';

    $source = 'ru';
    $target = 'uk';

    $trans = new GoogleTranslate();

    $result = $trans->translate($source, $target, $text);

    if ($result == '') {
      return false;
    } else {
      return $result;
    }

  }

  public static function is_url($url)
  {
    $response = array();
    //Check if URL is empty
    if (!empty($url)) {
      $response = get_headers($url);
    }
    return (bool)in_array("HTTP/1.1 200 OK", $response, true);
    /*Array
    (
        [0] => HTTP/1.1 200 OK
        [Date] => Sat, 29 May 2004 12:28:14 GMT
        [Server] => Apache/1.3.27 (Unix)  (Red-Hat/Linux)
        [Last-Modified] => Wed, 08 Jan 2003 23:11:55 GMT
        [ETag] => "3f80f-1b6-3e1cb03b"
        [Accept-Ranges] => bytes
        [Content-Length] => 438
        [Connection] => close
        [Content-Type] => text/html
    )*/
  }

  /**
   * @param $img
   * @return bool
   */
  public static function is_image($img)
  {

    if (self::is_url($img)) {
      if (getimagesize($img)) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  /**
   * @param $string
   * @return string
   */
  public static function rus2translit($string)
  {
    $converter = array(
      'а' => 'a', 'б' => 'b', 'в' => 'v',
      'г' => 'g', 'д' => 'd', 'е' => 'e',
      'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
      'и' => 'i', 'й' => 'y', 'к' => 'k',
      'л' => 'l', 'м' => 'm', 'н' => 'n',
      'о' => 'o', 'п' => 'p', 'р' => 'r',
      'с' => 's', 'т' => 't', 'у' => 'u',
      'ф' => 'f', 'х' => 'h', 'ц' => 'c',
      'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
      'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
      'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

      'А' => 'A', 'Б' => 'B', 'В' => 'V',
      'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
      'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
      'И' => 'I', 'Й' => 'Y', 'К' => 'K',
      'Л' => 'L', 'М' => 'M', 'Н' => 'N',
      'О' => 'O', 'П' => 'P', 'Р' => 'R',
      'С' => 'S', 'Т' => 'T', 'У' => 'U',
      'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
      'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
      'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
      'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
    );
    return strtr($string, $converter);
  }

  /**
   * @param $str
   * @return null|string|string[]
   */
  public static function translit($str)
  {
    // переводим в транслит
    $str = self::rus2translit($str);

    // в нижний регистр
    $str = strtolower($str);

    // заменям все ненужное нам на "-"
    $str = preg_replace('/[^-a-z0-9_]+/', '-', $str);

    // удаляем начальные и конечные '-'
    $str = trim($str, "-");

    $str = trim($str);

    return $str;
  }


  public static function clear_string($string)
  {

    $clear = trim($string);
    $clear = htmlentities($clear);

    $clear = rtrim($clear, '.');

    if (strpos($clear, '...') !== false) {
      $clear = str_replace('...', '', $clear);
    }

    $clear = str_replace("&nbsp;", '', $clear);

    $clear = trim($clear, ' ');
    $clear = str_replace('-', '', $clear);
    $clear = str_replace('-', '', $clear);

    $clear = preg_replace("/&#?[a-z0-9]+;/i", "", $clear);

    //$clear = htmlspecialchars($clear);

    $clear = trim($clear);

    return $clear;
  }


}

