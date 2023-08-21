<?php

namespace App\Observers;

use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use App\Notifications\ExpenseCreated;

class ExpensesObserver
{
    /**
     * Handle the Expense "created" event.
     */
    public function created(Expense $expense): void
    {
        $user = $expense->user;
        $user->notify(new ExpenseCreated($expense));
    }

}
