<?php
namespace FwEloquent\migrations;

class FWMigrateExample extends \Fwork\Migration
{
	protected $connection = 'default';
	

	public function up()
	{
		if (!$this->getSchema()->hasTable('table_example')) {
		 	$this->getSchema()->create('table_example', function($table) {		 		
		 		$table->increments('id');
	            $table->text('comment')->nullable();
	            $table->integer('reference_id')->nullable();
	            $table->timestamps();
	        });
	 	}
	}

	public function down()
	{
	 	$this->getSchema()->dropIfExists('table_example');
	}
}