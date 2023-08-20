<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'occurrence_date',
        'user_id',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

}
