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
    
    public function login($email, $password)
    {
        $user = DB::table('usuarios')-> where('email',$email)->first();
        if(!$user) throw new \Exception('Usuario no encontrado'); 
        if (!$user->activo) throw new \Exception('Usuario inactivo');
        Hash::check($password, $user->password) ?: throw new \Exception('Contraseña incorrecta');
        $token = JWTAuth::tokenById($user->id_usuario);        
        return $token; 
        
    }
    
    public function logout($token)
    {
        try
        {
            JWTAuth::setToken($token);
            JWTAuth::invalidate(); 
            return true; 

        }catch (\Exception $e)
        {
            throw new \Exception('Error al cerrar sesión: ' . $e->getMessage());
        }
       
    }
    
    public function validateToken($token)
    {
        try
        {
            JWTAuth::setToken($token); 
            return JWTAuth::check();
        }
        catch (\Exception $e)
        {
            return false; 
        }
    }
    
    public function getUserFromToken($token)
    {   
        try
        {
            JWTAuth::setToken($token); 
            $payload = JWTAuth::getPayload(); 
            $userId = $payload -> get('sub'); 
            $user = DB::table('usuarios')->where('id_usuario', $userId)->first(); 
            if(!$user)
            {
                return null; 
            }
            unset($user->password);
            return $user; 

        }
        catch (\Exception $e)
        {
            throw new \Exception('Token inválido o usuario no encontrado');
        }
        
    }
}