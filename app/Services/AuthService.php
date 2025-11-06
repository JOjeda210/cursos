<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{
    public function register($data)
    {
        $passwordHash = Hash::make($data['password']); 
        $userData =[
            'email' => $data['email'],
            'password' => $passwordHash, 
            'nombre' => $data['nombre'], 
            'apellido' => $data['apellido'], 
            'id_rol' => 2, 
            'activo' => true, 
            'fecha_registro' => now()
        ];

        $userId = DB::table('usuarios') -> insertGetId($userData); 
        $user =  DB::table('usuarios') -> where('id_usuario', $userId)-> first(); 
        unset($user->password); 

        return $user;

    }
    
    
    
    public function validateToken($token)
    {
        
    }
    
    public function getUserFromToken($token)
    {
        
    }
}