<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the successful creation of a new customer.
     */
    public function test_customer_creation_successful()
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);

        $this->assertNotNull($customer);
        $this->assertEquals('John Doe', $customer->name);
        $this->assertEquals('customer.john@example.com', $customer->email);
        $this->assertEquals('(82) 3561-3037', $customer->phone);
        $this->assertEquals('140.873.430-30', $customer->document);
    }

    /**
     * Test the successful update of a customer.
     */
    public function test_customer_update_successful()
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);

        $customer->update([
            'name' => 'Jane Doe',
            'email' => 'customer.jane@example.com',
            'phone' => '(82) 3561-3038',
            'document' => '140.873.430-31',
        ]);

        $customer->refresh();

        $this->assertEquals('Jane Doe', $customer->name);
        $this->assertEquals('customer.jane@example.com', $customer->email);
        $this->assertEquals('(82) 3561-3038', $customer->phone);
        $this->assertEquals('140.873.430-31', $customer->document);
    }

    /**
     * Test the successful deletion of a customer.
     */
    public function test_customer_delete_successful()
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);

        $customer->delete();
        $this->assertNull(Customer::find($customer->id));
    }

    /**
     * Test customer creation fails without required fields.
     */
    public function test_customer_creation_fails_without_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
        ]);
    }

    /**
     * Test customer creation fails with duplicate email.
     */
    public function test_customer_creation_fails_with_duplicate_email()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);

        Customer::create([
            'name' => 'Jane Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3038',
            'document' => '140.873.430-31',
        ]);
    }

    /**
     * Test customer delete fails with invalid ID.
     */
    public function test_customer_delete_fails_with_invalid_id()
    {
        $customer = Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);

        $customer->delete();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $nonExistentCustomer = Customer::findOrFail($customer->id);
        $nonExistentCustomer->delete();
    }
}
