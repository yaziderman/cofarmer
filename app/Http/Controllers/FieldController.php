<?php

namespace App\Http\Controllers;
use App\Fields;
use App\Http\Controllers\Utilities\BaseController as BaseController;
use Auth;
use Validator;
use App\Http\Requests\FieldRequest;
use Illuminate\Http\Request;

class FieldController extends BaseController
{


    /**
     * @SWG\Get(
     *   path="/fields",
     *   summary="list fields",
     *   tags={"Fields"},
     *   operationId="ApiV1IndexField",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with fields"
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
       return Fields::all();
    }

    /**
     * @SWG\Get(
     *   path="/fields/{fieldId}",
     *   tags={"Fields"},
     *   summary="List field details",
     *   operationId="ApiV1ShowField",
     *   @SWG\Parameter(
     *     name="fieldId",
     *     in="path",
     *     description="Target field",
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
    public function show(Fields $field)
    {
        return Fields::find($field)->first();
    }

    /**
     * @SWG\Post(
     *     path="/fields",
     *     tags={"Fields"},
     *     operationId="ApiV1StoreUser",
     *     summary="Add Field",
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
    public function store(FieldRequest $request)
    {
        $field = Fields::create(array_merge($request->all(), ['user_id' => Auth::guard('api')->id()]));

        return response()->json($field, 201);
    }

    /**
     * @SWG\Put(
     *     path="/fields/{fieldId}",
     *     tags={"Fields"},
     *     operationId="ApiV1UpdateField",
     *     summary="Update Field",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="fieldId",
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
    public function update(FieldRequest $request, Fields $field)
    {
        if (!$this->canUserUpdate($field)){
             return $this->sendError('Not Allowed', 'You are not the owner of the field', 403);
        }
        
        $field->update($request->all());
        
        return response()->json($field, 200);
    }


    /**
     * @SWG\Delete(
     *      path="/fields/{fieldId}",
     *      tags={"Fields"},
     *      operationId="ApiV1DeleteField",
     *      summary="Delete Field",
     *      @SWG\Parameter(
     *          name="fieldId",
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
    public function delete(Request $request, Fields $field)
    {

        if (!$this->canUserUpdate($field)){
             return $this->sendError('Not Allowed', 'You are not the owner of the field', 403);
        }
        
        try {
               $field->delete();
        } 
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return $this->sendError('Integrity Constraints Validation Error.', 'Another entity depends on this object, delete it first!', 400);
                //$e->errors()
            }

        }
        return response()->json(null, 204);
    }

    private function canUserUpdate($field){
        if (!Auth::guard('api')->user()->canUpdate($field)){
            return false;
        }

        return true;
    }
}