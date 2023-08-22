<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpenseTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    
    protected ExpenseService $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->serviceMock = App::make(ExpenseService::class);
    }

    private function getRandomId(): int
    {
        return Expense::select('id')->inRandomOrder()->first()->id ?? 1;
    }

    private function getFakeData(): array
    {
        return Expense::factory()->make()->toArray();
    }

    public function testGetReturnsInstanceOfExpenseModel()
    {
        $mockedExpense = $this->serviceMock->get($this->getRandomId());
        $this->assertInstanceOf(Expense::class, $mockedExpense);
    }

    public function testStoreReturnsInstanceOfExpenseModel()
    {
        $mockedExpense = $this->serviceMock->store($this->getFakeData());
        $this->assertInstanceOf(Expense::class, $mockedExpense);
    }

    public function testUpdateReturnsInstanceOfExpenseModel()
    {
        $mockedExpense = $this->serviceMock->update($this->getRandomId(), $this->getFakeData());
        $this->assertInstanceOf(Expense::class, $mockedExpense);
    }

    public function testCanGetExpenseDescription()
    {
        $expense = $this->serviceMock->get($this->getRandomId());
        $this->assertTrue(!empty($expense->description));
        $this->assertTrue(is_string($expense->description));
    }

    public function testCanGetExpenseValue()
    {
        $expense = $this->serviceMock->get($this->getRandomId());
        $this->assertTrue(!empty($expense->value));
        $this->assertTrue(is_numeric($expense->value));
    }

    public function testGetExpenseReturnsInstanceOfCollection()
    {
        $mockedExpense = $this->serviceMock->getCollection();
        $this->assertInstanceOf(Collection::class, $mockedExpense);
    }

    public function testCanDestroyExpenseValue()
    {
        $expense = $this->serviceMock->destroy($this->getRandomId());
        $this->assertTrue(is_null($expense));
    }

}
