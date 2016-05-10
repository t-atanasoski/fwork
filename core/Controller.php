<?php
namespace Fwork;
class Controller{
	protected $config;


	public function __construct()
	{
		$this->_loadConfig();	
	}

	protected function _loadConfig($filename = '')
	{
		$filename = $filename != '' ? $filename : get_called_class();
		$this->config = new Config($filename);
	}

	protected function _loadHelper($helper)
	{
		if (is_array($helper) && count($helper) > 0) {
			foreach($helper as $help_v){
				if(is_file($this->config->get('paths.helpers').$help_v.'.php')){
					include_once $this->config->get('paths.helpers').$help_v.'.php';
				}
			}
		} else {
			if (is_file($this->config->get('paths.helpers').$helper.'.php')) {
				include_once $this->config->get('paths.helpers').$helper.'.php';
			}
		}
	}
}