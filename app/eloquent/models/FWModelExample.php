<?php
namespace FwEloquent\models;

class FWModelExample extends \Fwork\Model
{
    protected $table = 'table_example';
    protected $fillable = array('comment');
    protected $connection = 'default';
    protected $casts = array("reference_id" => "integer");

    public $timestamps = true;

}
