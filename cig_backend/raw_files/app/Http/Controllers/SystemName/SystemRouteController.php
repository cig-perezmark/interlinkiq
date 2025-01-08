<?php

/**
 * 
 * replace the SystemName based on the Folder
 * 
*/
namespace App\Http\Controllers\SystemName;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller; 
use App\Http\Controllers\SystemName\ModuleOne\RouteController as ModuleOneRouteController;
use App\Http\Controllers\SystemName\ModuleTwo\RouteController as ModuleTwoRouteController;

class SystemRouteController extends Controller
{
    public static function registerRoutes()
    {

        //rename system-name the system name and ApiController to Module API Controller 
        Route::prefix('system-name')->middleware(['jwt', 'user-permission'])->group(function () {
            
            ModuleOneRouteController::moduleRoute();
            ModuleTwoRouteController::moduleRoute();
            // Add other routes for other ApiController as needed
        });

    }
}
