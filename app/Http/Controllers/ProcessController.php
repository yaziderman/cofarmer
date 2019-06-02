<?php

namespace App\Http\Controllers;
use App\Processes;
use App\Http\Requests\ProcessRequest;
use App\Http\Controllers\Utilities\BaseController as BaseController;
use Illuminate\Http\Request;
use Auth;
use Validator;

class ProcessController extends BaseController
{

    /**
     * @SWG\Get(
     *   path="/processes",
     *   summary="list processes",
     *   tags={"Processes"},
     *   operationId="ApiV1IndexProcess",
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
    public function index()
    {
       return Processes::with('tractor', 'field')->get();
    }

    /**
     * @SWG\Get(
     *   path="/processes/{processId}",
     *   tags={"Processes"},
     *   summary="List process details",
     *   operationId="ApiV1ShowProcess",
     *   @SWG\Parameter(
     *     name="processId",
     *     in="path",
     *     description="Target process",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error"),
     *   security={{"default":{}}}
     * )
     *
     */
    public function show(Processes $process)
    {
    	$proc = Processes::find($process)->first();
    	$proc->field;
    	$proc->tractor;
    	return $proc;
    }


    /**
     * @SWG\Post(
     *     path="/processes",
     *     tags={"Processes"},
     *     operationId="ApiV1StoreUser",
     *     summary="Add Process",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="tractor_id",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="field_id",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="area",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="planned_date",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     security={{"default":{}}}
     * )
     */ 
    public function store(ProcessRequest $request)
    {
        $process = Processes::create($request->all());

        return response()->json($process, 201);
    }


    /**
     * @SWG\Put(
     *     path="/processes/{processId}",
     *     tags={"Processes"},
     *     operationId="ApiV1UpdateProcess",
     *     summary="Update Process",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="processId",
     *          in="path",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="tractor_id",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="field_id",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="area",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="planned_date",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     security={{"default":{}}}
     * )
     */ 
    public function update(ProcessRequest $request, Processes $process)
    {
        $process->update($request->all());

        return response()->json($process, 200);
    }

    /**
     * @SWG\Delete(
     *      path="/processes/{processId}",
     *      tags={"Processes"},
     *      operationId="ApiV1DeleteProcess",
     *      summary="Delete Process",
     *      @SWG\Parameter(
     *          name="processId",
     *          in="path",
     *          required=true, 
     *          type="integer" 
     *      ),
     *      @SWG\Response(
     *          response=204,
     *          description="Success"
     *      ),
     *      @SWG\Response(
     *          response=403,
     *          description="Not Allowed"
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="Bad Request"
     *      ),
     *      security={{"default":{}}}
     * )
     */

    public function delete(Processes $process)
    {
        $process->delete();

        return response()->json(null, 204);
    }

  /**
     * @SWG\Put(
     *     path="/processes/{processId}/approve",
     *     tags={"Processes"},
     *     operationId="ApiV1ApproveProcess",
     *     summary="Approve Process",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="processId",
     *          in="path",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="Success"
     *     ),
     *     @SWG\Response(
     *          response=403,
     *          description="Not Allowed"
     *     ),
     *     @SWG\Response(
     *          response=208,
     *          description="Already approved"
     *     ),
     *     @SWG\Response(
     *          response=503,
     *          description="Not able to approve the process"
     *     ),
     *     security={{"default":{}}}
     * )
     */ 
    public function approveProcess($process){
    	
		if (!Auth::guard('api')->user()->isAdmin()){
            return $this->sendError('Not Allowed', 'Only admins can approve processes', 403);
        }

        $proc = Processes::find($process)->first();
        
        if ($proc->isApproved()){
        	return $this->sendError('Already approved', 'The process is already approved', 208);	
        }

    	if (!$proc->approve()){
        	return $this->sendError('Approval failed', 'The approval has failed', 503);	
    	}
        return response()->json(null, 204);
    }
}