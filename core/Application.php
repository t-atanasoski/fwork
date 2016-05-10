<?php
namespace Fwork;

class Application
{
    private $url_controller = null;
    private $url_action = null;
    private $url_params = array();

    private static $instance;
    public static $capsule;
    private $arguments;

    private $config;
    

    public static function init($arguments)
    {
        Application::getInstance();

        self::$instance->arguments = $arguments;
        self::$instance->resolveUrl();
        self::$instance->config = new Config();
        self::$instance->loadDbConnections();

        if (!self::$instance->url_controller) {
            require self::$instance->config->get('paths.controllers').self::$instance->config->get('defaults.controller').'.php';

            self::$instance->url_controller = ucfirst(self::$instance->config->get('defaults.controller'));
            self::$instance->url_action     = self::$instance->config->get('defaults.action');

            (new self::$instance->url_controller())->{self::$instance->url_action}();

        } elseif (file_exists(self::$instance->config->get('paths.controllers') . self::$instance->url_controller . '.php')) {

            require self::$instance->config->get('paths.controllers') . self::$instance->url_controller . '.php';

            //self::$instance->url_controller = new self::$instance->url_controller();

            if (is_callable( array( self::$instance->url_controller, self::$instance->url_action), true )) {

                if (!empty(self::$instance->url_params)) {
                    call_user_func_array(array((new self::$instance->url_controller()), self::$instance->url_action), self::$instance->url_params);
                } else {
                    (new self::$instance->url_controller())->{self::$instance->url_action}();
                }

            } else {
                if (strlen(self::$instance->url_action) == 0) {
                    self::$instance->url_action     = self::$instance->config->get('defaults.action');
                    (new self::$instance->url_controller())->{self::$instance->config->get('defaults.action')}();
                }
                else {
                    header('location: ' . self::$instance->config->get('urls.site_url') . 'error');
                }
            }
        } else {
            header('location: ' . self::$instance->config->get('urls.site_url') . 'error');
        }
    }

    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new Application();
        }

        return self::$instance;
    }

    public function getConfig()
    {
        return self::$instance->config;
    }

    private function loadDbConnections()
    {
        $db_connections = $this->config->get('database');
        self::$capsule = new \Illuminate\Database\Capsule\Manager;

        if($db_connections && count($db_connections) > 0){
            foreach ($db_connections as $db_key => $db_value) {
                 self::$capsule->addConnection($db_value, $db_key);   
            }
            self::$capsule->setAsGlobal();
            self::$capsule->bootEloquent(); 

        }
    }

    /**
    * Function for resolving url, sets controller, action and parameters
    * Console usage example: "php index.php controller/action key1=value1 key2=value=2"
    **/
    private function resolveUrl()
    {
        if ( isset($_GET['url']) ){
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = explode('/', $url);

            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = (isset($url[1]) && strpos($url[1], '_') !== 0) ? $url[1] : null;
            unset($url[0], $url[1]);
            unset($_GET['url']);

            $this->url_params = $_GET;
        }elseif( defined('STDIN') && isset($this->arguments[1]) ){
            $url = trim($this->arguments[1], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = (isset($url[1]) && strpos($url[1], '_') !== 0) ? $url[1] : null;
            unset($url[0], $url[1]);
            unset($this->arguments[0], $this->arguments[1]);

            if(count($this->arguments) > 0){
                foreach($this->arguments as $arg_v){
                    $exploded = explode('=', $arg_v);
                    if(count($exploded) == 2){
                        $this->url_params[$exploded[0]] = $exploded[1];    
                    }                    
                }
            }
        }
    }

    public function getController()
    {
        return $this->url_controller;
    }
    public function getAction()
    {
        return $this->url_action;
    }
    public function getParams()
    {
        return $this->url_params;
    }
}