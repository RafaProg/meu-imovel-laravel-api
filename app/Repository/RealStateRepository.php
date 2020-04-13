<?php
namespace App\Repository;

class RealStateRepository extends AbstractRepository
{
	public function __construct(Model $model, Request $request = null)
    {
        parent::__construct($model, $request);

        $location;
        
        if($request) {
            $location = $request->all(['city', 'state']);

            return $this->model->whereHas('address', function($query) use ($location) {
                $query->where('state_id', $location['state'])
                      ->where('city_id', $location['city']);
            });
        }
    }
}
