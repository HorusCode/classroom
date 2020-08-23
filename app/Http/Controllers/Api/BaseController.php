<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Default success response format
     * @param string|array $result
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result = [], $message = 'Success!') {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message
        ], 200);
    }

    /**
     * Default error response format
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404) {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
