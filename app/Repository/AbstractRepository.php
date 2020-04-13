<?php
namespace App\Repository;

use Illuminate\Http\Request
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
	/**
	 * @var Model
	 */
	protected $model;

	public function __construct(Model $model, Request $request = null)
	{
		$this->model = $model;
        
        if($request) {
            if($request->has('condiction')) {
                $this->selectCondictions($request->query('condictions'));
            }

            if($request->has('filter')) {
                $this->selectFilter($request->query('filters'));
            }
        }
	}

	public function selectCoditions($coditions)
	{
		$expressions = explode(';', $coditions);
		foreach($expressions as $e) {
			$exp = explode(':', $e);

			$this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
		}
	}

	public function selectFilter($filters)
	{
		$this->model = $this->model->selectRaw($filters);
	}

	public function getResult()
	{
		return $this->model;
	}
}
