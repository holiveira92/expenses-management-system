<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class ExpenseRepository implements RepositoryInterface
{
    protected Expense $model;

    public function __construct(Expense $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with("user")->get();
    }

    public function get(int $expenseId): Expense
    {
        return $this->model->with("user")->find($expenseId);
    }

    public function getByUser(int $expenseId, ?string $filterDate=null): Collection
    {
        $query = $this->model->where('user_id', $expenseId);

        if (!empty($filterDate)) {
            $query->where('occurrence_date', $filterDate);
        }

        return $query->with("user")->get();
    }

    public function destroy(int $expenseId): void
    {
        DB::transaction(function () use ($expenseId) {
            return $this->model->findOrFail($expenseId)->delete();
        });
    }

    public function paginated(int $recordsPerPage): array
    {
        return $this->model->paginate($recordsPerPage)->toArray();
    }

    public function create(array $data): Expense
    {
        $expense = DB::transaction(function () use ($data) {
            $model = new Expense();
            $model->fill($data);
            $model->save();
            return $model;
        });
        return $expense;
    }

    public function persist(int $expenseId, array $data): Expense
    {
        $expense = DB::transaction(function () use ($expenseId, $data) {
            $model = $this->model->findOrFail($expenseId);
            $model->fill($data);
            $model->save();
            return $model;
        });
        return $expense;
    }
}
