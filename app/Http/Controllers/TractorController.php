<?php

namespace App\Http\Controllers;
use App\Tractors;
use App\Http\Controllers\Utilities\BaseController as BaseController;
use App\Http\Requests\TractorRequest;
use Illuminate\Http\Request;
use Validator;

class TractorController extends BaseController
{


// Auth::guard('api')->user(); // instance of the logged user
// Auth::guard('api')->check(); // if a user is authenticated
// Auth::guard('api')->id(); // the id of the authenticated user
    
    /**
     * @SWG\Get(
     *   path="/tractors",
     *   summary="list tractors",
     *   tags={"Tractors"},
     *   operationId="ApiV1IndexTractor",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with tractors"
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
       return Tractors::all();
    }

    /**
     * @SWG\Get(
     *   path="/tractors/{tractorId}",
     *   tags={"Tractors"},
     *   summary="List tractor details",
     *   operationId="ApiV1ShowTractor",
     *   @SWG\Parameter(
     *     name="tractorId",
     *     in="path",
     *     description="Target tractor",
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
    public function show(Tractors $tractor)
    {
        return Tractors::find($tractor)->first();
    }

/**
     * @SWG\Post(
     *     path="/tractors",
     *     tags={"Tractors"},
     *     operationId="ApiV1StoreUser",
     *     summary="Add Tractor",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="name",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Parameter(
     *          name="crops_type",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Parameter(
     *          name="area",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     security={{"default":{}}}
     * )
     */
    public function store(TractorRequest $request)
    {
        $tractor = Tractors::create($request->all());

        return response()->json($tractor, 201);
    }

/**
     * @SWG\Put(
     *     path="/tractors/{tractorId}",
     *     tags={"Tractors"},
     *     operationId="ApiV1UpdateTractor",
     *     summary="Update Tractor",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="tractorId",
     *          in="path",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Parameter(
     *          name="name",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Parameter(
     *          name="crops_type",
     *          in="formData",
     *          required=true, 
     *          type="string" 
     *     ),
     *     @SWG\Parameter(
     *          name="area",
     *          in="formData",
     *          required=true, 
     *          type="integer" 
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     security={{"default":{}}}
     * )
     */
    public function update(TractorRequest $request, Tractors $tractor)
    {
        $tractor->update($request->all());

        return response()->json($tractor, 200);
    }

    /**
     * @SWG\Delete(
     *      path="/tractors/{tractorId}",
     *      tags={"Tractors"},
     *      operationId="ApiV1DeleteTractor",
     *      summary="Delete Tractor",
     *      @SWG\Parameter(
     *          name="tractorId",
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

    public function delete(Tractors $tractor)
    {

        try {
         $tractor->delete();
        } 
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return $this->sendError('Integrity Constraints Validation Error.', 'Another entity depends on this object, delete it first!', 400);
                //$e->errors()
            }

        }

        return response()->json(null, 204);
    }
}