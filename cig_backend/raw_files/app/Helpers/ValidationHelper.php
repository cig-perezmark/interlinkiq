<?php

namespace App\Helpers;
use App\Helpers\ResponseHelper;


class ValidationHelper
{
    // Property to hold the ResponseHelper instance
    protected $response;

    // Constructor to initialize $this->response
    public function __construct()
    {
        // Assign the ResponseHelper instance to $this->response
        $this->response = new ResponseHelper();
    }

    public function validateRequest($request, $accepted_parameters = [], $required_fields = []) {
        // Get all the parameters from the request
        $payload = $request->all();
    
        // Check if there are any keys in the request that are not in the accepted parameters
        foreach ($payload as $key => $value) {
            // If the key is not in accepted parameters and is not 'user_id', return an error
            if (!in_array($key, $accepted_parameters) && $key !== 'user_id') {
                return $this->response->invalidParameterResponse();
            }
        }
    
        // If 'user_id' is not in the accepted parameters, remove it from the payload
        if (!in_array('user_id', $accepted_parameters)) {
            unset($payload['user_id']);
        }
    
        // Check if all required fields are present in the request
        foreach ($required_fields as $field) {
            if (!isset($payload[$field]) || empty($payload[$field])) {
                return $this->response->requiredFieldMissingResponse();
            }
        }
    
        // If everything is valid, return the payload (or continue with further processing)
        return $payload;
    }
    

    
}