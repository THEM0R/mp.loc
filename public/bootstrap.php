<? use core\Router, lib\App;
// ini
ini_set( 'date.timezone', 'Europe/Kiev' );
ini_set('display_errors','on');
ini_set('serialize_precision','on');
error_reporting(-1 );
session_start();
// define
define('REQUEST', 'http');
// composer
require ( '../vendor/autoload.php' );
use Symfony\Component\Debug\Debug;
Debug::enable();
// define
require('../engine/config/define.php');
// require
require ( LIB.'function.php' );
// Run
require ( ENGINE.'routes.php' );
Router::Run();
