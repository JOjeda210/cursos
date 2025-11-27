<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Modules\StoreModuleRequest;
use App\Http\Requests\Modules\UpdateModuleRequest;
use app\Services\ModuleService;
use app\Services\AuthService;

class ModuleController extends Controller
{
    protected $_moduleService; 
    protected $_authService; 
    public function __construct(ModuleService $moduleService, AuthService $authService)
    {
       $this->_moduleService = $moduleService;
       $this->_authService = $authService;
    }

}
