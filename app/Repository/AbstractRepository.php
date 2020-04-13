<?php
namespace App\Repository;

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
                $this->selectCondictions($request->query('condiction'));
            }

            if($request->has('filter')) {
                $this->selectFilters($request->query('filter'));
            }
        }
    }

    public function selectCondictions($condictions)
    {
        $expressions = explode(';', $condictions);

        foreach($expressions as $expression) {
            $expression = explode(':', $expression);

            $this->model = $this->model->where($expression[0], $expression[1], $expression[2]);
        }
    }

    public function selectFilters($filters)
    {
        $this->model = $this->model->selectRaw($filters);
    }

    public function getResult()
    {
        return $this->model;
    }
}
