<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginService;
use App\Http\Requests\Login\LoginPostRequest;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    protected LoginService $loginService;

    /**
     * Construtor da classe, injetando serviços necessários
     * @return void
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Realiza o login na aplicação e gera um token válido
     * @param LoginPostRequest $request - credenciais do usuário
     * @return JSON - dados do token gerado
     */
    public function login(LoginPostRequest $request)
    {   
        try {
            $validatedRequest = $request->validated();
            $response = $this->loginService->login($validatedRequest['email'], $validatedRequest['password']);
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Internal Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o logout na aplicação e cancela o token que estava sendo utilizado
     * @param Request $Request - Dados da request
     * @return JSON - dados do token revogado
     */
    public function logout(Request $request)
    {
        try {
            $this->loginService->logout($request->bearerToken());
            return response()->json(['message' => "Logout successfully"], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Internal Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
