<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    public function all(): Collection;

    public function get(int $resourceId): mixed;

    public function paginated(int $recordsPerPage): array;

    public function destroy(int $resourceId): void;

    public function persist(int $resourceId, array $data): mixed;

}
