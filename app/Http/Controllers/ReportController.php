<?php

namespace App\Http\Controllers;

use App\Processes;
use App\Http\Controllers\Utilities\BaseController as BaseController;
use Illuminate\Http\Request;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class ReportController extends LaravelController
{
	use EloquentBuilderTrait;

	/**
     * @SWG\Get(
     *   path="/smart-report",
     *   summary="Smart Reporting Endpoint, still under progress",
     *   tags={"Reports"},
     *   operationId="ApiV1ReportProcesses",
	 *	 @SWG\Parameter(
     *     name="includes[]",
     *     in="query",
     *     description="A list of entity types (separated by new lines) to filter the Returns: field and tractor",
 	 *     required=false,
 	 *     type="array",
 	 *     collectionFormat="multi",
 	 *     uniqueItems=true,
 	 *     @SWG\Items(type="string")
 	 *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with processes"
     *   ),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthenticated"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ), 
     *   security={
     *    {
     *      "default": {}
     *    }
     *   }
     * )
     */
	 public function getProcesses()
    {
        // Parse the resource options given by GET parameters
        $resourceOptions = $this->parseResourceOptions();

        // Start a new query for processes using Eloquent query builder
        // (This would normally live somewhere else, e.g. in a Repository)
        $query = Processes::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $processes = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($processes, $resourceOptions, 'processes');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

	public function filterIsApproved(Builder $query, $method, $clauseOperator, $value, $in)
	{
	    // check if value is true
	    if ($value) {
	        $query->where('id', "1");
	    }
	}    
}
