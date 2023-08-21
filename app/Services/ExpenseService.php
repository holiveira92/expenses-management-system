<?php

namespace App\Services;

use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Database\Eloquent\Collection;

class ExpenseService
{
    protected ExpenseRepository $repository;

    /**
     * Construtor da classe, injetando serviços necessários
     * @return void
     */
    public function __construct(ExpenseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Obtém coleção de despesas
     * @return array - lista de despesas
     */
    public function getCollection(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Persiste o cadastro de uma despesa na base de dados aplicação
     * @param array $requestData - Dados da despesa
     * @return Expense - dados da despesa
     */
    public function store(array $requestData): Expense
    {
        return $this->repository->create($requestData);
    }

    /**
     * Obtém coleção de dados de despesas filtradas por usuário
     * @param int $userId - ID do usuario
     * @return Collection - collection de despesas
     */
    public function getAllExpensesByUser(int $userId, ?string $filterDate=null): Collection
    {
        return $this->repository->getByUser($userId, $filterDate);
    }

    /**
     * Realiza a atualização da despesa na base de dados
     * @param int $userId - ID do recurso
     * @return Expense - dados do usuário
     */
    public function update(int $userId, array $requestData): Expense
    {
        return $this->repository->persist($userId, $requestData);
    }

    /**
     * Obtendo a despesa específica pelo ID
     * @param int $expenseId - ID do recurso
     * @return Expense $expense
     */
    public function get(int $expenseId): Expense
    {  
        return $this->repository->get($expenseId);
    }

    /**
     * remove a despesa no sistema
     * @param int $expenseId - ID da despesa
     * @return void
     */
    public function destroy(int $expenseId): void
    {  
        $this->repository->destroy($expenseId);
    }
}