<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase, InteractsWithDatabase;

    /**
     * Test the successful creation of a new user
     */
    public function test_user_creation_successful()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /**
     * Test the successful update of a user
     */
    public function test_user_update_successful()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->update([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('newpassword'),
        ]);

        $user->refresh();

        $this->assertEquals('Jane Doe', $user->name);
        $this->assertEquals('jane.doe@example.com', $user->email);
        $this->assertTrue(Hash::check('newpassword', $user->password));
    }

    /**
     * Test the successful delete of a user
     */
    public function test_user_delete_successful()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->delete();
        $this->assertNull(User::find($user->id));
    }

    /**
     * Test the fail new user creation
     */
    public function test_user_creation_fails_without_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'name' => 'John Doe',
            'password' => Hash::make('password'),
        ]);
    }


    /**
     * Test the fail of user creation with duplicate email
     */
    public function test_user_creation_fails_with_duplicate_email()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        // Tenta criar outro usuário com o mesmo email
        User::create([
            'name' => 'Jane Doe 2',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    /**
     * Test the fail of user update with duplicate email
     */
    public function test_user_update_fails_with_duplicate_email()
    {
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $user2->update([
            'email' => 'john.doe@example.com',
        ]);
    }

    
    /**
     * Test the fail of user deletion when user not found
     */
    public function test_user_delete_fails_when_user_not_found()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->delete();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $nonExistentUser = User::findOrFail($user->id);
        $nonExistentUser->delete();
    }
}
