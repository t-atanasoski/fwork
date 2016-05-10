<?php

class Home extends FwLibraries\TwController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		//example of loading helper
		$this->_loadHelper('cdn');

		//example of getting config value
		$database_name = $this->config->get('database.default.database');

		//example of dumping view
		$this->_dumpView('home/index.twig', array(
            'database_name'   	=> $database_name,
            'welcome_message'  	=> 'Welcome!!!'
        ));
	}
}