<?php
namespace App\Http\Controllers\Utilities;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http"},
 *     @SWG\SecurityScheme(
 *          securityDefinition="default",
 *          type="apiKey",
 *          in="header",
 *          name="Authorization"
 *     ),
 *     host=L5_SWAGGER_CONST_HOST,
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="CoFarmer Web Services Documentation",
 *         description="Swagger documentation for the Main Web Services of the Backend infrastructure of the CoFarmer Project",
 *         @SWG\Contact(
 *             email="yazd.erman@gmail.com"
 *         ),
 *     )
 * )
 */

class BaseController extends Controller
{

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}