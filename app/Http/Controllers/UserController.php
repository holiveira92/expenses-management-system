<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\UserService;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\Users\UsersCollection;
use App\Http\Resources\Users\UsersResource;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * Construtor da classe, injetando serviços necessários
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Função inicial de get do endpoint
     * Realiza a busca dos itens para listagem
     * @return JSON
     */
    public function index()
    {   
        try{
            //Obtendo coleção de dados na base
            $response = $this->userService->getCollection();
            return response()->json(new UsersCollection($response), Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o cadastro de um usuário na aplicação
     * @param CreateRequest $request - Dados do usuário
     * @return JSON - dados de criação do usuário
     */
    public function store(CreateRequest $request)
    { 
        try {
            $response = $this->userService->store($request->validated());
            return response()->json($response, Response::HTTP_OK); 
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o cadastro de um usuário na aplicação
     * @param UpdateRequest $request - Dados do usuário
     * @return JSON - dados de criação do usuário
     */
    public function update(int $userId, UpdateRequest $request)
    { 
        try {
            $response = $this->userService->update($userId, $request->all());
            return response()->json($response,Response::HTTP_OK);  
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Show the specified resource.
     * @param int $id
     */
    public function show(int $userId)
    {
        try {
            $response = $this->userService->getUser($userId);
            return response()->json(new UsersResource($response), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
