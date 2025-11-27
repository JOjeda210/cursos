<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Lessons\StoreLessonRequest;
use App\Http\Requests\Modules\UpdateModuleRequest;
use App\Services\LessonService;
use App\Services\AuthService;
use Tymon\JWTAuth\Exceptions\JWTException;

class LessonController extends Controller
{
    protected $_authService; 
    protected $_lessonService;
    public function __construct(LessonService $lService, AuthService $authService ) 
    {
        
    }
}
