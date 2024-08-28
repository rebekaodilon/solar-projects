<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\Customer;
use App\Enums\InstallationTypeEnum;
use App\Enums\UFEnum;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer()
    {
        return Customer::create([
            'name' => 'John Doe',
            'email' => 'customer.john@example.com',
            'phone' => '(82) 3561-3037',
            'document' => '140.873.430-30',
        ]);
    }

    private function createProject(Customer $customer, array $attributes = [])
    {
        return Project::create(array_merge([
            'customer_id' => $customer->id,
            'description' => 'Project 1 description',
            'installation_type' => InstallationTypeEnum::FIBROCIMENTO_MADEIRA,
            'state' => UFEnum::SP,
        ], $attributes));
    }

    /**
     * Test the successful creation of a new project.
     */
    public function test_project_creation_successful()
    {
        $customer = $this->createCustomer();
        $project = $this->createProject($customer);

        $this->assertNotNull($project);
        $this->assertEquals('Project 1 description', $project->description);
        $this->assertEquals(InstallationTypeEnum::FIBROCIMENTO_MADEIRA, $project->installation_type);
        $this->assertEquals(UFEnum::SP, $project->state);
    }

    /**
     * Test the successful update of a project.
     */
    public function test_project_update_successful()
    {
        $customer = $this->createCustomer();
        $project = $this->createProject($customer);

        $project->update([
            'description' => 'Project 2 description',
            'installation_type' => InstallationTypeEnum::FIBROCIMENTO_METALICO,
            'state' => UFEnum::RJ,
        ]);

        $project->refresh();

        $this->assertEquals('Project 2 description', $project->description);
        $this->assertEquals(InstallationTypeEnum::FIBROCIMENTO_METALICO, $project->installation_type);
        $this->assertEquals(UFEnum::RJ, $project->state);
    }

    /**
     * Test the successful deletion of a project.
     */
    public function test_project_delete_successful()
    {
        $customer = $this->createCustomer();
        $project = $this->createProject($customer);

        $project->delete();

        $this->assertNull(Project::find($project->id));
    }

    /**
     * Test project creation fails without a valid customer.
     */
    public function test_project_creation_fail()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Project::create([
            'customer_id' => 999, // non-existent customer id
            'description' => 'Project 1 description',
            'installation_type' => InstallationTypeEnum::FIBROCIMENTO_MADEIRA,
            'state' => UFEnum::SP,
        ]);
    }

    /**
     * Test project update fails with invalid data.
     */
    public function test_project_update_fail()
    {
        $customer = $this->createCustomer();
        $project = $this->createProject($customer);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $project->update([
            'customer_id' => 999, // non-existent customer id
            'description' => 'Project 2 description',
            'installation_type' => InstallationTypeEnum::FIBROCIMENTO_METALICO,
            'state' => UFEnum::RJ,
        ]);
    }

    /**
     * Test project deletion fails when trying to delete a non-existent project.
     */
    public function test_project_delete_fail()
    {
        $customer = $this->createCustomer();
        $project = $this->createProject($customer);

        $project->delete();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Project::findOrFail($project->id)->delete();
    }

    /**
     * Test project creation fails without required fields.
     */
    public function test_project_creation_fails_without_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Project::create([
            'customer_id' => 1,
            'description' => 'Project 1 description',
        ]);
    }
}
