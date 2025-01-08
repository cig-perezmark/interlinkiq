<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseHelper;


class PermissionController extends Controller
{

    public const GET_PERMISSION_ALIAS = "GET_CORE_ACCOUNTS_ALIAS";

    public const POST_PERMISSION_ALIAS = "POST_CORE_ACCOUNT_MODULE_ALIAS";

    public const PUT_PERMISSION_ALIAS = null;

    public const DELETE_PERMISSION_ALIAS = null;

    public const FILE_UPLOAD_PERMISSION_ALIAS = null;



    protected $accepted_parameters = [
        "id",
        "user_id",
        "functions_id",
        "system_id"
    ];

    protected $required_fields = [
        "id",
        "user_id",
        "permission"
    ];

    protected $response_column = [
        "id",
        "user_id",
        "permission"
    ];


    protected $response;
    protected $permission;
    



    public function __construct(Request $request)
    {
        $this->response = new ResponseHelper($request);
        /**
         * 
         *  Rename system_database_connection based on preferred database on database.php
         * 
        */
        $this->permission = DB::connection("permissions_connection");
    }

    public function viewUserPermission(Request $request, $id = null)
    {
        // Convert the request data to an array
        $request = $request->all();

        // Validate $id
        if (is_null($id) || empty($id)) {
            return $this->response->errorResponse("No ID provided.");
        }

        // Validate $request->user_id
        if (!isset($request['user_id']) || empty($request['user_id'])) {
            return $this->response->errorResponse("No USER ID provided.");
        }

        // Fetch current user data
        $current_user_data = $this->permission->table("user_information")
                                            ->where("id", $id)
                                            ->first();

        // Fetch target user data
        $target_user_data = ($id == $request['user_id'])
            ? $current_user_data
            : $this->permission->table("user_information")
                            ->where("id", $request['user_id'])
                            ->first();

        // Validate user data
        if (is_null($current_user_data)) {
            return $this->response->errorResponse("Current user not found.");
        }

        if (is_null($target_user_data)) {
            return $this->response->errorResponse("Target user not found.");
        }

        // Check role hierarchy
        if ($current_user_data->role > $target_user_data->role) {
            return $this->response->errorResponse(
                "The role of {$target_user_data->first_name} is higher than yours."
            );
        }

        // Fetch permissions for both users
        $current_user_permissions = $this->fetchUserPermissions($current_user_data->id);
        $target_user_permissions = ($current_user_data->id == $target_user_data->id)? $current_user_permissions: $this->fetchUserPermissions($target_user_data->id);

        // Prepare response data
        $data = [
            "id" => $id,
            "user_id" => $target_user_data->id,
            "first_name" => $target_user_data->first_name,
            "middle_name" => $target_user_data->middle_name,
            "last_name" => $target_user_data->last_name,
            "suffix_name" => $target_user_data->suffix_name,
            "role" => $target_user_data->role,
            "current_user_permission" => $this->permissionFormatter($current_user_permissions),
            "target_user_permission" => $this->permissionFormatter($target_user_permissions),
        ];

        return $this->response->successResponse($data);
    }

    

    public function insertUserPermission(Request $request){


        $request = $request->all();
        if(empty($request)){
            return $this->response->errorResponse("Empty Parameters");
        }
        // Ensure request is not empty
        else{
            // Get all request keys
            $requestKeys = array_keys($request);
            // Check if there are any unexpected keys
            if (!empty(array_diff($requestKeys, $this->accepted_parameters))) {
                return $this->response->invalidParameterResponse();
            }

            if($request['id'] == $request['user_id']){
                return $this->response->errorResponse("Can't Add Permission to yourself");
            }
            else{
                $current_user_data = $this->permission->table("user_information")->where("id",$request['id'])->get()->first();
                $target_user_data =  ($request['id'] == $request['user_id']) ? $current_user_data: $this->permission->table("user_information")->where("id", $request['user_id'])->first();

                if(is_null($current_user_data) || is_null($target_user_data)){
                    return $this->response->errorResponse("No Found User!");
                }
                else{
                    if($current_user_data->role > $target_user_data->role){
                        return $this->response->errorResponse("Can't add permission to Higher Role!");
                    }
                    else{

                        $current_user_permissions = $this->permission->table("account_permissions as ap")
                                                                     ->join("functions as f", "ap.functions_id", "=", "f.id")
                                                                     ->join("modules as m", "f.module_id", "=", "m.id")
                                                                     ->join("systems as s", "m.system_id", "=", "s.id")
                                                                     ->where("ap.user_id",$current_user_data->id)
                                                                     ->where("s.id",$request['system_id'])
                                                                     ->select("ap.functions_id")
                                                                     ->get();

                        foreach ($current_user_permissions as $cup) {
                            if (in_array($cup->functions_id, $request['functions_id'])) {
                                continue;
                            }
                            return $this->response->errorResponse("You Have no Permissions with this");
                        }

                        $idsToDelete = $this->permission->table("account_permissions as ap")
                                                        ->join("functions as f", "ap.functions_id", "=", "f.id")
                                                        ->join("modules as m", "f.module_id", "=", "m.id")
                                                        ->join("systems as s", "m.system_id", "=", "s.id")
                                                        ->where("ap.user_id", $target_user_data->id)
                                                        ->where("s.id", $request['system_id'])
                                                        ->pluck('ap.id'); 

                        

                        try{
                            $this->permission->beginTransaction();
                            if($idsToDelete->isEmpty()){
                                $data = [];

                                foreach($request['functions_id'] as $ids){
                                    $insert_data = [
                                        'user_id' => $request['user_id'],
                                        'functions_id' => $ids
                                    ];
                                    $data[] = $insert_data;
                                }
                                $result_data = $this->permission->table("account_permissions")->insert($data);
                                if($result_data){
                                    $this->permission->commit();
                                    return $this->response->successResponse("Permissions are successfully set!");
                                }else{
                                    $this->permission->rollback();
                                    return $this->response->errorResponse("Somethings went wrong!");
                                }

                            }
                            if($this->permission->table("account_permissions")->whereIn('id', $idsToDelete)->delete()){

                                $data = [];

                                foreach($request['functions_id'] as $ids){
                                    $insert_data = [
                                        'user_id' => $request['user_id'],
                                        'functions_id' => $ids
                                    ];
                                    $data[] = $insert_data;
                                }
                                $result_data = $this->permission->table("accounts_permission")->insert($data);
                                if($result_data){
                                    $this->permission->commit();
                                    return $this->response->successResponse("Permissions are successfully set!");
                                }else{
                                    $this->permission->rollback();
                                    return $this->response->errorResponse("Somethings went wrong!");
                                }

                            }
                            else{
                                $this->permission->rollback();
                                return $this->response->errorResponse("Somethings Wrong");
                            }
                           

                        }
                        catch(QueryException $e){
                            return $this->response->errorResponse($e);
                        }
                        catch(Exception $e) {
                            return $this->response->errorResponse($e);
                        }


                    }
                }
            }
        }
    }

    

    public function delete($id){

        //check if the id is numeric and has value
        if (empty($id) && !is_numeric($id)) {
            return $this->response->errorResponse("Invalid Request");
        }

        $request = $request->all();
        if(!isset($request['id']) || empty($request['id']) || !is_numeric($request['id'])){
            //if id is not set in $request, empty or non numeric
            return $this->response->invalidParameterResponse();
        }
        if($request['id'] != $id){
            //if ids doesnt match
            return $this->response->errorResponse("ID doesn't match!");
        }

        try{

             /**
             * 
             * 
             * insert your code here
             * 
             * can remove this comment after
             * 
             * 
             * */

        }
        catch(QueryException $e){
            return $this->response->errorResponse($e);
        }
        catch(Exception $e) {
            return $this->response->errorResponse($e);
        }
    }

    public function upload(Request $request, $id){

         /**
         * 
         * start with other validations here
         * 
         * */


        try{

             /**
             * 
             * 
             * insert your code here
             * 
             * can remove this comment after
             * 
             * 
             * */

        }
        catch(QueryException $e){
            return $this->response->errorResponse($e);
        }
        catch(Exception $e) {
            return $this->response->errorResponse($e);
        }
    }


    private function permissionFormatter($user_permissions){
        // Process the user permissions into a structured format
        $systems = [];
        foreach ($user_permissions as $row) {
            if (!isset($systems[$row->system_name])) {
                $systems[$row->system_name] = [
                    'id' => $row->id,
                    'system_name' => $row->system_name,
                    'system_alias' => $row->system_alias,
                    'system_description' => $row->system_description,
                    'unique_identifier' => $row->unique_identifier,
                    'modules' => []
                ];
            }

            $modules = &$systems[$row->system_name]['modules'];
            if (!isset($modules[$row->module_name])) {
                $modules[$row->module_name] = [
                    'id' => $row->id,
                    'module_name' => $row->module_name,
                    'module_alias' => $row->module_alias,
                    'module_description' => $row->module_description,
                    'unique_identifier' => $row->unique_identifier,
                    'functions' => []
                ];
            }

            $functions = &$modules[$row->module_name]['functions'];
            if (!isset($functions[$row->functions_name])) {
                $functions[$row->functions_name] = [
                    'id' => $row->id,
                    'function_name' => $row->functions_name,
                    'function_alias' => $row->functions_alias,
                    'function_description' => $row->functions_description,
                    'event_type' => $row->event_type,
                    'unique_identifier' => $row->unique_identifier
                ];
            }

        }

        // Flatten the structure for JSON response
        $permission = array_values(array_map(function ($system) {
            $system['modules'] = array_values(array_map(function ($module) {
                $module['functions'] = array_values($module['functions']);
                    return $module;
            }, $system['modules']));
            return $system;
        }, $systems));

        return $permission;

    }

    /**
     * Fetch user permissions from the database.
     */
    private function fetchUserPermissions($user_id)
    {
        return $this->permission->table("account_permissions as ap")
                                ->join("functions as f", "ap.functions_id", "=", "f.id")
                                ->join("modules as m", "f.module_id", "=", "m.id")
                                ->join("systems as s", "m.system_id", "=", "s.id")
                                ->where("ap.user_id", $user_id)
                                ->get();
    }


    //
}
