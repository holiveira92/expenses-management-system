<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    
    protected UserService $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->serviceMock = App::make(UserService::class);
    }

    private function getRandomUserId(): int
    {
        return User::select('id')->inRandomOrder()->first()->id ?? 1;
    }

    private function getUpdateData(): array
    {
        return [
            "name" => "UPDATED",
            "email" => fake()->unique()->safeEmail()
        ];
    }

    private function getCreatedData(): array
    {
        return [
            "name" => "CREATED",
            "email" => fake()->unique()->safeEmail(),
            "password" => Hash::make("test")
        ];
    }

    public function testGetReturnsInstanceOfUserModel()
    {
        $mockedUser = $this->serviceMock->getUser($this->getRandomUserId());
        $this->assertInstanceOf(User::class, $mockedUser);
    }

    public function testCanGetUserName()
    {
        $user = $this->serviceMock->getUser($this->getRandomUserId());
        $this->assertTrue(!empty($user->name));
        $this->assertTrue(is_string($user->name));
    }

    public function testCanGetUserEmail()
    {
        $user = $this->serviceMock->getUser($this->getRandomUserId());
        $this->assertTrue(!empty($user->email));
        $this->assertTrue(is_string($user->email));
    }

    public function testUpdateUserReturnsInstanceOfUserModel()
    {
        $user = User::findOrFail($this->getRandomUserId());
        $mockedUser = $this->serviceMock->update($user->id, $this->getUpdateData());
        $this->assertInstanceOf(User::class, $mockedUser);
    }

    public function testUpdateUserValidSaveName()
    {
        $user = User::findOrFail($this->getRandomUserId());
        $mockedUser = $this->serviceMock->update($user->id, $this->getUpdateData());
        $this->assertEquals($this->getUpdateData()["name"], $mockedUser->name);
    }

    public function testGetUsersReturnsInstanceOfCollection()
    {
        $mockedUser = $this->serviceMock->getCollection();
        $this->assertInstanceOf(Collection::class, $mockedUser);
    }

    public function testCreateUserReturnsInstanceOfUserModel()
    {
        $mockedUser = $this->serviceMock->store($this->getCreatedData());
        $this->assertInstanceOf(User::class, $mockedUser);
    }

    public function testCreateUserValidSaveName()
    {
        $mockedUser = $this->serviceMock->store($this->getCreatedData());
        $this->assertEquals($this->getCreatedData()["name"], $mockedUser->name);
    }


}
