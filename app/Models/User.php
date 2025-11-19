<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class User implements Authenticatable, JWTSubject
{
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    // Métodos de Authenticatable
    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id_usuario'] ?? null;
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'] ?? null;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        //
    }

    public function getRememberTokenName()
    {
        return null;
    }

    // Métodos de JWTSubject
    public function getJWTIdentifier()
    {
        return $this->attributes['id_usuario'] ?? null;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Método estático para buscar por ID usando Query Builder
    public static function find($id)
    {
        $user = DB::table('usuarios')->where('id_usuario', $id)->first();
        return $user ? new static((array) $user) : null;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
}
