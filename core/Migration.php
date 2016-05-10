<?php 
namespace Fwork;

class Migration extends \Illuminate\Database\Migrations\Migration
{
	private $schema;
	public function __construct()
	{
		$capsule = \Fwork\Application::$capsule;
		
		$this->schema = $capsule::schema($this->connection);
	}

	protected function getSchema()
	{
		return $this->schema;
	}
}