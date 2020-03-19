<? namespace core;

class DB
{
    protected $pdo;
    protected static $instance;

    /**
     * DB constructor.
     */
    protected function __construct()
    {
        $db = require_once CONF . 'db.php';

        require_once LIB . 'rb.php';

        \R::setup($db['dsn'], $db['user'], $db['pass']);
        //\R::freeze( true );
        //\R::fancyDebug( true );

        if( !\R::testConnection() )
        {
            exit('Нет Соединения с БД');
        }

        \R::ext('xDispense', function($table){
            return \R::getRedBean()->dispense($table);
        });

        // unset optimize
        unset($db);

    }

    /**
     * @return DB
     */
    public static function instance()
    {
        if( self::$instance === null )
        {
            self::$instance = new Self;
        }
        return self::$instance;
    }

}