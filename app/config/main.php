<?php
return array(
	'paths' => 
		array(
			'helpers' 		=> APP.'helpers/',
			'controllers' 	=> APP.'controllers/',
			'views'			=> APP.'views/',
			'config'		=> APP.'config/',
			'models'		=> APP.'eloquent/models/',
			'repos'			=> APP.'eloquent/repos/'
		),
	'urls' => 
		array(
			'site_url' 		=> getenv('site_url')
		),
	'defaults' =>
		array(
			'controller' => 'home',
            'action'    => 'index'
		),
	'database' => array(
		'default' => array(
			'driver'	=> 'mysql',
			'host' 		=> getenv('db_host'),
			'database'	=> getenv('db_name'),
			'username'	=> getenv('db_user'),
			'password'	=> getenv('db_pass'),
			'charset'	=> 'utf8',
			'collation'	=> 'utf8_unicode_ci',
			'prefix'	=> ''
		)
	)
);