<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $repository;

    /**
     * Construtor da classe, injetando serviços necessários
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persiste o cadastro de um usuário na base de dados aplicação
     * @param array $requestData - Dados do usuário
     * @return User - dados do usuário
     */
    public function store(array $requestData): User
    {
        return $this->repository->create($requestData);
    }

    /**
     * Obtém coleção de dados
     * @return array - lista de usuários
     */
    public function getCollection(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Realiza a atualização do recurso na base de dados
     * @param int $userId - ID do recurso
     * @return User - dados do usuário
     */
    public function update(int $userId, array $requestData): User
    {
        return $this->repository->persist($userId, $requestData);
    }

    /**
     * Obtendo usuário específico pelo ID
     * @param int $userId - ID do recurso
     * @return User $user
     */
    public function getUser(int $userId): User
    {  
        return $this->repository->get($userId);
    }
}