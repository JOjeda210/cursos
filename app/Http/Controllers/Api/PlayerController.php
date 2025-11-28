<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\PlayerService;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlayerController extends Controller
{
    protected $_authService;
    protected $_playerService;

    public function __construct(AuthService $authService, PlayerService $playerService)
    {
        $this->_authService = $authService;
        $this->_playerService = $playerService;
    }

    public function getCourseContent($idCurso)
    {
        try {
            $token = JWTAuth::getToken();
            $user = $this->_authService->getUserFromToken($token);

            $content = $this->_playerService->getCourseContent($idCurso, $user->id_usuario);

            return response()->json($content, 200);

        } catch (\Exception $e) {
            $status = $e->getCode() === 403 ? 403 : 500;
            return response()->json(['error' => $e->getMessage()], $status);
        }
    }
}