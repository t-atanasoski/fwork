<?php
namespace FwEloquent\repos;
use FwEloquent\models\FWModelExample;

class FwRepositoryExample extends \Fwork\Repository
{
	protected $model = 'FwEloquent\models\FWModelExample';

	public function getById($id)
	{
		return FWModelExample::where('id', '=', $id)->get();
	}
}