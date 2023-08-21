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

    public static function userCanSave(User $user, Expense $expense)
    {
        return $expense->user->is($user);
    }

    public static function userCanView(User $user, Expense $expense)
    {
        return $expense->user->is($user);
    }

    public static function userCanCreate(User $user, int $requestUserId)
    {
        return $user->id === $requestUserId;
    }

}
