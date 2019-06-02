<?php

namespace App\Http\Controllers;
use App\Processes;
use EloquentBuilder;
//use App\EloquentFilters\Processes\DatedFilter;
//use App\EloquentFilters\Tractors\WithTractorFilter;
use Illuminate\Http\Request;

class ReportBasicController extends Controller
{
    
	/**
     * @SWG\Get(
     *   path="/report",
     *   summary="Basic Reporting Endpoint",
     *   tags={"Reports"},
     *   operationId="ApiV1ReportProcesses",
	 *	 @SWG\Parameter(
     *     name="with_tractor",
     *     in="query",
     *     description="Tractor Id to be filtered by",
 	 *     required=false,
 	 *     type="integer",
 	 *    ),
 	 *	 @SWG\Parameter(
     *     name="for_field",
     *     in="query",
     *     description="field ID to be filtered by",
 	 *     required=false,
 	 *     type="integer",
 	 *    ),
 	 *	 @SWG\Parameter(
     *     name="dated",
     *     in="query",
     *     description="List the processes which start with the provided date",
 	 *     required=false,
 	 *     type="string",
 	 *    ),
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
	 public function getProcesses(Request $request)
    {
    	$query = Processes::with(['field','tractor'])->where('approved', true);
		$processes = EloquentBuilder::to(
                    $query,
                    $request->all()
                 );
        $data = $processes->get();
        $stats = [];
        $resp = [];
        $resp['records'] = $data;

        $processedArea = 0;
        foreach ($data as $key => $value) {
        	$processedArea += $value->area;
        }

        $resp['processed_area'] = $processedArea;

        // Create JSON response of parsed data
        return response()->json($resp, 200);
	}    
}
