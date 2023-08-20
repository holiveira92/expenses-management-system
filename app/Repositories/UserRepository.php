<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements RepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function get(int $userId): User
    {
        return $this->model->find($userId);
    }

    public function destroy(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            return $this->model->findOrFail($userId)->delete();
        });
    }

    public function paginated(int $recordsPerPage): array
    {
        return $this->model->paginate($recordsPerPage)->toArray();
    }

    public function create(array $data): User
    {
        $user = DB::transaction(function () use ($data) {
            $model = new User();
            $model->fill($data);
            $model->save();
            return $model;
        });
        return $user;
    }

    public function persist(int $userId, array $data): User
    {
        $user = DB::transaction(function () use ($userId, $data) {
            $model = $this->model->findOrFail($userId);
            $model->fill($data);
            $model->save();
            return $model;
        });
        return $user;
    }
}
