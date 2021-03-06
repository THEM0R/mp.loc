<?



define('DOMEN', REQUEST.'://' . $_SERVER['HTTP_HOST']);
// dir
define('DIR',     dirname( dirname(__DIR__) ) );
define('FW',      DIR.'/engine');
define('ENGINE',  FW.'/' );
define('CORE',    DIR.'/engine/core/' );
define('APP',     DIR.'/app' );
define('LIB',     FW.'/libs/' );
define('CONF',    FW.'/config/' );
define('MOVE_DB', dirname(DIR).'/public/data/movie/' );
define('CONF_DB', dirname(DIR).'/public/data/' );
define('PUBLICS',  DIR.'/public/' );
define('UPLOAD',  DIR.'/public/upload/' );
define('UPLOAD_IMG',  DIR.'/public/upload/images/' );


define('UPL_ART',  DIR.'/public/upload/images/articles/posters' );
define('URL_ART', '/public/upload/images/articles/posters' );

define('UPL_DRA',  DIR.'/public/upload/images/articles/drawings' );
define('URL_DRA', '/public/upload/images/articles/drawings' );

define('UPL_ART_SCR',  DIR.'/public/upload/images/gallery' );
define('URL_ART_SCR', '/public/upload/images/gallery' );

define('UPL_CSV',  DIR.'/public/upload/csv' );
define('URL_CSV', '/public/upload/csv' );

define('UPL_SLID',  DIR.'/public/upload/images/slider' );
define('URL_SLID', '/public/upload/images/slider' );

define('UPL_GALR',  DIR.'/public/upload/images/gallery' );
define('URL_GALR', '/public/upload/images/gallery' );

define('COUNT_ART_SCR', 5);

define('CONTENT', DOMEN.'/public/' );
define('CONTENT_ADMIN', DOMEN.'/public/admin' );
define('SCRIPT',  dirname(DIR).'/public/script/' );
define('SCRIPT_LIB',  '/public/script/libs/' );
define('SCRIPT_JS',  '/public/script/js/' );
define('SCRIPT_HTML',  dirname(DIR).'/public/script/html/' );
define('VENDOR',  DIR.'/' );


// meta
define('META_DESCRIPTION','Приватне підприємство «Металік-Плюс»<br><br>
        займається виробництвом: блок-хаусу, евро-брусу, металочерепиці, профнастилу, 
        <br>металоштахетника та аксесуарів для даху.
        <br>виконуємо комплектацію стандартних та індивідуальних рохмірів.<br><br>
        
        Завод «Металік-Плюс» знаходиться в місті Калуш, Івано-Франківської області.
        <br>Початок діяльності було покладено в 2007 році.<br>
        
        За 12 років свого існування фірма змогла завоювати довіру своїх клієнтів.
        <br>«Металік-Плюс» знають і поважають в Україні!.<br><br>
        
        Швидкість виконання роботи, 
        індевідуальний підхід та оптимальні ціни - це те,
        <br>що робить продукцію заводу привабливою та вигідною для покупців!');


define('META_KEYWORDS','ключевие слова');
define('META_TITLE','Главная');

define('LANGUAGE', 'ru');
define('AUTH', 'authorization');
define('ACTION', 'action');

define("POSTER_LIMIT_SIZE", 1024 * 1024); // 1MB
define('THEME', 'default');
define('PER_PAGE', 15); // количиство товаров на страницу
define('SORTING', 'sorting');
//
define('DOMEN_NAME','MOR.CX');

define('WWW',     __DIR__);

define('SLIDER_IMG', '/public/upload/slider/' );

define('POSTER_DIR',    'public/upload/poster' );
define('POSTER_NAME',    'logo_' );
define('POSTER_MINI_DIR',    'public/upload/poster' );
define('POSTER_BIG_DIR',    'public/upload/poster_big' );
define('SCREEN_DIR',    'public/upload/screen' );
define('SCREEN_NAME',    'img_' );
define('CACHE',         'public/upload/cache/');

// captcha

define('CAPTCHA', 'captcha_code');
