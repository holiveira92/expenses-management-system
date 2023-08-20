<?php

namespace App\Http\Resources\Expenses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Users\UsersResource;

class ExpensesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'occurrence_date' => $this->occurrence_date,
            'user_id' => $this->user_id,
            'value' => $this->value,
            'user' => new UsersResource($this->user),
        ];
    }
}
