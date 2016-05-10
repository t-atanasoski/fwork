<?php
namespace Fwork;
class Config
{
	private $data = array();
	private $default;
	private $controller;

	public function __construct($controller = '')
	{
		$this->default['main'] = include APP.'config/main.php';
		$this->controller = $controller;
		
		$config = array();

		if (isset($this->default['main']['paths']['config']) && file_exists($this->default['main']['paths']['config'] . strtolower($this->controller) . '.php')) {
			$config[strtolower($this->controller)] = include $this->default['main']['paths']['config'] . strtolower($this->controller) . '.php';

			if(!is_array($config[strtolower($this->controller)])){
				die('invalid config file for '.strtolower($this->controller));
			}

		}
		
		$this->data = array_merge($this->default, $config);	
	}

	public function get($name)
	{
		if(isset($this->data[strtolower($this->controller)]) && $controller_config = $this->resolve($this->data[strtolower($this->controller)], $name)){
			return $controller_config;
		}elseif($main_config = $this->resolve($this->data['main'], $name)){
			return $main_config;
		}else{
			return false;
		}
		
	}

	private function resolve($array, $path)
	{
        if (!empty($path)) {
            $keys = explode('.', $path);
            foreach ($keys as $key) {
                if (is_array($array) && isset($array[$key])) {
                    $array = $array[$key];
                } else {
                    return false;
                }
            }
        }

        return $array;
	}

}