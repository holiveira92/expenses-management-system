<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ExpensePolicy
{
    use HandlesAuthorization;
    
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function canDoSomethingWith(User $user, Expense $expense)
    {
        return $expense->user->is($user);
    }

}
