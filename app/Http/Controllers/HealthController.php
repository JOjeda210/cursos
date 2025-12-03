<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class HealthController extends Controller
{
    public function check(){
        try
        {
            DB::select('SELECT 1'); 
            return "Conexion exitosa a la DB";
        }
        catch (Exception $ex)
        {
            return 'Error de conexión: ' . $ex->getMessage();
        };
    }
}
