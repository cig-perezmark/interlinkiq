<?php

namespace App\Helpers;

use Tymon\JWTAuth\Contracts\JWTSubject;

class CustomUser implements JWTSubject
{
    protected $id;
    protected $user_permissions;

    public function __construct($id, $user_permissions)
    {
        $this->id = $id;
        $this->user_permissions = $user_permissions;
    }

    // Return the identifier of the user
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    // Return custom claims to be included in the JWT payload
    public function getJWTCustomClaims()
    {
        return [
            'user_permissions' => $this->user_permissions,
        ];
    }
}