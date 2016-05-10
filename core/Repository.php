<?php
namespace Fwork;

abstract class Repository
{
	protected $model;

	public function create(array $attributes)
	{
		return call_user_func_array("{$this->model}::create", array($attributes));
	}

	public function all($columns = array('*'))
	{
		return call_user_func_array("{$this->model}::all", array($columns));
	}

	public function find($id, $columns = array('*'))
	{
		return call_user_func_array("{$this->model}::find", array($id, $columns));
	}
	
	public function destroy($ids)
	{
		return call_user_func_array("{$this->model}::destroy", array($ids));
	}

    public function get_model()
    {
        return $this->model;
    }
}