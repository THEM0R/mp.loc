<? namespace mvc;

use lib\App;
use lang\Language;

class View
{
    public $meta = [];

    public $controller;

    public $script = [];

    /*
     * @array $route
     * текущий маршрут
     */
    public $route = [];

    /*
     * @var $view
     * текущий вид
     */
    public $view;

    /*
     * @var $templates
     * текущий шаблон
     */
    public $theme;

    public function __construct($route, $theme = null, $view = null, $meta = [])
    {

        $this->route = $route;
        $this->controller = App::lowerCamelCase($route['controller']);
        $this->theme = $theme ?: THEME;
        $this->view = $view;
        $this->script = App::$config['script'];
        $this->meta = $meta;
        // code

        // unset optimize
        unset($route);
        unset($theme);
        unset($view);
        unset($meta);

    }

    private function replaceHtml($file)
    {
        if (is_file($file)) {

            $file = file_get_contents($file);

            $html = str_replace("{","<?=$",$file);
            $html = str_replace("}",";?>",$html);

            return $html;

/*            return preg_replace("#{(.+)}#", "<?=$$1;?>", file_get_contents($file));*/
        }
        return false;
    }


    public function rendering($vars)
    {
        $script = $this->script;
        $all = compact('script');
        $vars = array_merge($all, $vars);

        // unset optimize
        unset($script);
        unset($all);

        if ($this->view == false) App::NotFound();

        if (is_array($vars)) extract($vars);

        // unset optimize
        //unset($vars);


        /*
         * $content
         */
        $file_view = APP . '/views/' . $this->theme . '/' . App::lowerCamelCase($this->view) . '.html';

        if($file_view){



            $file_view = $this->replaceHtml($file_view);



            ob_start();
            if (is_file($file_view)) {

                //pr1($file_view);
                //echo $file_view;
//                require $file_view;
            }
            $content = ob_get_clean();


            // unset optimize
            unset($file_view);

        }else{
            App::NotFound();
        }


        /*
         * $content end
         */

        /*
         * $module
         */

        if ($modules !== []) {
            foreach ($modules as $name => $file) {
                if ($file) {
                    if (is_file($file)) {

                        //$file = $this->replaceHtml($file);

                        ob_start();

                        require $file;

                        $$name = ob_get_clean();
                        unset($file);
                        unset($name);
                    }
                }
            }
        }

        /*
         * $module end
         */

        if (false !== $this->theme) {

            $file_theme = APP . '/views/' . $this->theme . '/index.html';

            if (is_file($file_theme)) {
                require $file_theme;

            } else {
                App::NotFound();
            }

            // unset optimize
            unset($file_theme);

        } else {

            App::NotFound();
        }
    }

    public function require_pro($file)
    {
        if (is_file($file)) require($file);
    }
}