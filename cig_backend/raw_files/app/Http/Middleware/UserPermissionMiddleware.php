<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use ReflectionClass;

class UserPermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the current route action
        $action = Route::currentRouteAction();

        // Extract the controller and method
        [$controller, $method] = explode('@', $action);

        // Use ReflectionClass to get constants from the controller
        $reflection = new ReflectionClass($controller);

        // Build a constant name based on the method
        $constantName = strtoupper($method) . '_PERMISSION_ALIAS';

        // Check if the constant exists
        if ($reflection->hasConstant($constantName)) {
            $requiredPermission = $reflection->getConstant($constantName);
        } else {
            $requiredPermission = null; // Or handle missing constants as needed
        }

        // Retrieve user permissions from the request
        $userPermissions = $request->user_permissions ?? [];

        // Check if the required permission exists in the user's permission structure
        if ($this->hasPermission($userPermissions, $requiredPermission)) {
            return $next($request);
        }

        // Deny access if the user doesn't have the required permission
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'You do not have access to perform this action.',
        ], 403);
    }
    private function hasPermission(array $permissions, ?string $requiredPermission): bool
    {
        if ($requiredPermission === null) {
            return true; // Allow if no specific permission is required
        }

        foreach ($permissions as $system) {
            foreach ($system['modules'] ?? [] as $module) {
                foreach ($module['functions'] ?? [] as $function) {
                    if ($function['function_name'] === $requiredPermission ||
                        $function['function_alias'] === $requiredPermission) {
                        return true;
                    }
                }
            }
        }

        return false; // Permission not found
    }
}

