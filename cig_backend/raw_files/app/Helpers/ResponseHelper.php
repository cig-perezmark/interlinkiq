<?php

namespace App\Helpers;
use Illuminate\Http\Request;


class ResponseHelper
{
    protected $method;

    public function __construct(Request $request)
    {
        $this->method = $request->method();
    }


    // Success Response
    public function buildApiResponse($data = [], $response_column = []){
        // If data is a single object, convert it to an array (in case of a single object)
        if (is_object($data) && get_class($data) === 'stdClass') {
            $data = (array) $data;
        } else {
            if (is_object($data)) {
                // Convert each stdClass object to an associative array
                $data = array_map(function ($item) {
                    return (array)$item;
                }, $data->toArray());
            }
        }

        // Check if data is a multi-dimensional array
        if (count($data) === count($data, COUNT_RECURSIVE)) {
            // Not multi-dimensional
            $filtered = array_intersect_key($data, array_flip($response_column));
        } else {
            // Check if array has a normal multi-dimensional indexing
            if (array_key_exists(0, $data)) {
                $filtered = array_map(function ($arr) use ($response_column) {
                    return array_intersect_key($arr, array_flip($response_column));
                }, $data);
            } else {
                $filtered = array_intersect_key($data, array_flip($response_column));
            }
        }

        return response()->json([
            'status' => 'success',
            'method' => $this->method,
            'data' => $filtered
        ], 200);
    }

    public function successResponse($message = []){
        return response()->json([
            'status' => 'success',
            'method' => $this->method,
            'message' => $message,
        ], 200);
    }

    // Error Response (for validation or other errors)
    public function errorResponse($errors = []){
        return response()->json([
            'status' => 'fail',
            'method' => $this->method,
            'message' => $errors,
        ], 422);
    }

    public function invalidParameterResponse(){
        return response()->json([
            'status' => 'fail',
            'method' => $this->method,
            'message' => 'Invalid Parameters',
        ], 422);
    }

    public function requiredFieldMissingResponse(){
        return response()->json([
            'status' => 'fail',
            'message' => 'Required Fields are missing',
        ], 422);
    }

    //add error response incase there will be another error circumstances
}
