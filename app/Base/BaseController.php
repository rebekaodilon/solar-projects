<?php

namespace App\Base;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    protected $per_page     = 10;    // Default per page pagination
    public $repository      = null;
    public function __construct()
    { }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
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

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**
     * success soap response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSoapResponse($message, $code = 200)
    {
        return response($message, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSoapErrorResponse($error, $code = 400)
    {
        return response($error, $code, ['Content-Type' => 'application/xml']);

    }
}
