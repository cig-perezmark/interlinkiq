<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ResponseHelper;
use App\Helpers\CustomUser; 
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use App\Helpers\OTPHelper;
use Carbon\Carbon;


class AuthController extends Controller
{


    protected $accepted_parameters = [
        "id",
        "email", 
        "password",
        "otp"
    ];

    protected $required_fields = [
        "email", 
        "password"
    ];



    protected $response;
    protected $permission;
    protected $account;
    protected $otp;
    protected $table = 'accounts';
    protected $carbon;



    public function __construct(Request $request)
    {
        $this->response = new ResponseHelper($request);
        $this->otp = new OTPHelper;
        $this->carbon = new Carbon;

        /**
         * 
         *  Rename system_database_connection based on preferred database on database.php
         * 
        */
        $this->permission = DB::connection("permissions_connection");
        $this->account = DB::connection("accounts_connection");

    }


    public function login(Request $request)
    {
        try {
            $data = [];
            $credential = $request->all();

            if(empty($credential)){
                return $this->response->requiredFieldMissingResponse();
            }

            // Validate input parameters
            if (!empty($credential)) {
                foreach ($credential as $field => $value) {
                    if (!in_array($field, $this->accepted_parameters)) {
                        return $this->response->invalidParameterResponse();
                    }
                }
            }

            // Check required fields
            foreach ($this->required_fields as $required) {
                if (!isset($credential[$required]) || empty($credential[$required])) {
                    return $this->response->requiredFieldMissingResponse();
                }
            }

            // Search for the user account
            $user_accounts = $this->account->table("user_information")->where('email', $credential['email'])->first();

            // If no user found
            if (!$user_accounts) {
                return $this->response->errorResponse("No Email Found");
            }

            // Verify password
            if (!password_verify($credential['password'], $user_accounts->password)) {
                return $this->response->errorResponse("Invalid Password");
            }

            //check if there is a pending OTP that needs to verify
            $otp_data = $this->permission->table("otp")->where("user_id",$user_accounts->id)
                                                       ->where('iterations','<=','3')
                                                       ->where('is_verified',0)
                                                       ->where('is_done',0)
                                                       ->get()
                                                       ->first();

            $generate_otp = false;

            // no otp data
            if(is_null($otp_data)){
                $generate_otp = true;
            }
            else{
                //check otp if it is not expired
                if($this->otpDateValidation($otp_data->request_datetime)){
                    $generate_otp = false;
                    return $this->response->successResponse("Please enter OTP");
                }else{
                    $generate_otp = true;

                    if($this->permission->table('otp')->where('user_id',$otp_data->id)->where('otp',$otp_data->otp)->update(['is_done' => 1])){
                        $generate_otp = false;
                        return $this->response->errorResponse("OTP is Expired. Login Again");
                    }
                    
                }
            }

            //OTP Generation here
            if($generate_otp){
                
                $otp = $this->otp->generateOTP();

                //supply data
                $data = [
                    "user_id" => $user_accounts->id,
                    "otp" => $otp,
                    "request_datetime" => now(),
                    "iterations" => 0,
                    "is_verified" => 0,
                    "is_done" => 0,

                ];

                $this->account->beginTransaction();

                $query_result = $this->permission->table('otp')->insert($data);

                if(!$query_result){
                    $this->account->rollback();
                    return $this->response->errorResponse("Can't Generate OTP");
                }
                else{
                    $details = [
                        'name' => $user_accounts->first_name,
                        'message' => 'This is an email sent from Laravel. Your OTP is '.$otp.' . Do not share your OTP to anyone.',
                    ];
                    $subject = "OTP";
                    
                    Mail::to($user_accounts->email)->send(new Email($details, $subject));

                    $this->account->commit();
                    return $this->response->successResponse("The OTP is Sent to your Email");
                }
            }


        } catch (Exception $e) {
            return $this->response->errorResponse($e);
        } catch (QueryException $e) {
            return $this->response->errorResponse($e);
        }
    }

    public function otpVerification(Request $request){
        $otp_payload = $request->all();

        if(empty($otp_payload)){
            return $this->response->requiredFieldMissingResponse();
        }

        $required_fields = [
            "id",
            "otp"
        ];

        foreach ($required_fields as $required) {
            if (!isset($otp_payload[$required]) || empty($otp_payload[$required])) {
                return $this->response->requiredFieldMissingResponse();
            }
        }

        $otp_data = $this->permission->table('otp')
                                     ->where('user_id',$otp_payload['id'])
                                     ->where('iterations','<=','3')
                                     ->where('is_verified',0)
                                     ->where('is_done',0)
                                     ->get()
                                     ->first();

        if(is_null($otp_data)){
            return $this->response->errorResponse("No OTP Available");
        }
        $this->permission->beginTransaction();

        if($otp_data->iterations >= 3){

            if($this->permission->table('otp')->where('user_id',$otp_payload['id'])->where('otp',$otp_data->otp)->update(['is_done' => 1])){
                $this->permission->commit();
                return $this->response->errorResponse("3 OTP Error Attempts, Login Again");
            }
            else{
                $this->permission->rollback();
                return $this->response->errorResponse("Error Occured!");
            }
        }

        if($otp_data->otp != $otp_payload['otp']){

            if($this->permission->table('otp')->where('user_id',$otp_payload['id'])->where('otp',$otp_data->otp)->increment('iterations',1)){
                $this->permission->commit();
                return $this->response->errorResponse("Invalid OTP");
            }
            else{
                $this->permission->rollback();
                return $this->response->errorResponse("Error Occured!");
            }
        }
        else{
            if(!$this->otpDateValidation($otp_data->request_datetime)){
                $this->permission->rollback();
                return $this->response->errorResponse("OTP is Expired! Login Again");
            }
            if($this->permission->table('otp')->where('user_id',$otp_payload['id'])->where('otp',$otp_payload['otp'])->update(['is_verified' => 1, 'is_done' => 1])){
                
                $user_accounts = $this->account->table("user_information")->get()->where('id',$otp_payload['id'])->first();
                if(is_null($user_accounts)){
                    $this->permission->rollback();
                    return $this->response->errorResponse("No Account Found!");
                }
                else{

                    // Get user permissions
                    $user_permissions = $this->permission->table("account_permissions as ap")
                                                         ->join("functions as f", "ap.functions_id", "=", "f.id")
                                                         ->join("modules as m", "f.module_id", "=", "m.id")
                                                         ->join("systems as s", "m.system_id", "=", "s.id")
                                                         ->get()
                                                         ->where('user_id',$user_accounts->id);

                    if ($user_permissions->isEmpty()) {
                    // Generate bearer token with no permissions
                    $token = JWTAuth::fromUser(new CustomUser($user_accounts->id, []));
                    $data = [
                        "id" => $user_accounts->id,
                        "first_name" => $user_accounts->first_name,
                        "middle_name" => $user_accounts->middle_name,
                        "last_name" => $user_accounts->last_name,
                        "suffix_name" => $user_accounts->suffix_name,
                        "role" => $user_accounts->role,
                        "permission" => []
                    ];
                    } else {
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
                                    'system_id' => $row->system_id,
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
                                    'module_id' => $row->module_id,
                                    'function_name' => $row->functions_name,
                                    'function_alias' => $row->functions_alias,
                                    'function_description' => $row->functions_description,
                                    'event_type' =>$row->event_type,
                                    'unique_identifier' => $row->unique_identifier
                                ];
                            }

                        }

                        // Flatten the structure for JSON response
                        $user_permission = array_values(array_map(function ($system) {
                            $system['modules'] = array_values(array_map(function ($module) {
                                $module['functions'] = array_values($module['functions']);
                                return $module;
                            }, $system['modules']));
                            return $system;
                        }, $systems));

                        // Generate bearer token with user permissions
                        $token = JWTAuth::fromUser(new CustomUser($user_accounts->id, $user_permission));
                        $data = [
                            "id" => $user_accounts->id,
                            "first_name" => $user_accounts->first_name,
                            "middle_name" => $user_accounts->middle_name,
                            "last_name" => $user_accounts->last_name,
                            "suffix_name" => $user_accounts->suffix_name,
                            "role" => $user_accounts->role,
                            "bearer_token" => $token,
                            "permission" => $user_permission
                        ];
                    }

                    $login_data = [
                        "user_id" => $user_accounts->id,
                        "login_datetime" => now()
                    ];

                    if($this->permission->table("login_logs")->insert($login_data)){
                        $this->permission->commit();
                        return $this->response->successResponse($data); 
                    }
                    else{
                        $this->permission->rollback();
                        return $this->response->errorResponse("Error Occured! Can't Log In!");
                    }

                    

                }
            }
            else{
                $this->permission->rollback();
                return $this->response->errorResponse("Error Occured!");
            }


        }

    }

    /**
     *  
     * Returns True if the otp is valid 
     * Returns False if the otp expires
     * 
    */
    private function otpDateValidation($datetime){
        $database_time = $this->carbon->parse($datetime);
        $valid_time = $this->carbon->now()->subMinutes(5);
        if($database_time >= $valid_time){
            return true;
        }
        else{
            return false;
        }
    }



}
