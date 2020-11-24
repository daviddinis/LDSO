<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Car;
use App\Company;

use App\Http\Controllers;

class CarProfileTest extends TestCase
{

    public function testCars_MaintenanceShouldShowCorrectAmountForVehicle()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();

        // id 1 is johndoe@fe.up.pt
        $user1 = User::factory()->make(['id' => 1, 'company_id' => 1]);
        
        $response1 = $this->actingAs($user1)->get('/car/2/maintenances');

        $response1->assertViewIs('pages.maintenances');
        $response1->assertViewHas('maintenances');

        $numberOfMaintenances = $response1->getOriginalContent()->getData()['maintenances'];

        //See seed.sql for correct amount of maintenances for this vehicle
        $this->assertCount(7, $numberOfMaintenances);
    }


    public function testCars_TaxShouldShowCorrectAmountForVehicle()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();

        // id 1 is johndoe@fe.up.pt
        $user1 = User::factory()->make(['id' => 1, 'company_id' => 1]);
        
        $response1 = $this->actingAs($user1)->get('/car/2/taxes');

        $response1->assertViewIs('pages.taxes');
        $response1->assertViewHas('taxes');

        $numberOfTaxes = $response1->getOriginalContent()->getData()['taxes'];

        //See seed.sql for correct amount of tax for this vehicle
        $this->assertCount(5, $numberOfTaxes);
    }


    public function testCars_InsurancesShouldShowCorrectAmountForVehicle()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();

        // id 1 is johndoe@fe.up.pt
        $user1 = User::factory()->make(['id' => 1, 'company_id' => 1]);
        
        $response1 = $this->actingAs($user1)->get('/car/2/insurances');

        $response1->assertViewIs('pages.insurances');
        $response1->assertViewHas('insurances');

        $numberOfInsurances = $response1->getOriginalContent()->getData()['insurances'];

        //See seed.sql for correct amount of insurances for this vehicle
        $this->assertCount(2, $numberOfInsurances);
    }


    public function testCars_InspectionsShouldShowCorrectAmountForVehicle()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();
        
        // id 1 is johndoe@fe.up.pt
        $user1 = User::factory()->make(['id' => 1, 'company_id' => 1]);
        
        $response1 = $this->actingAs($user1)->get('/car/2/inspections');

        $response1->assertViewIs('pages.inspections');
        $response1->assertViewHas('inspections');

        $numberOfInspections = $response1->getOriginalContent()->getData()['inspections'];

        //See seed.sql for correct amount of inspections for this vehicle
        $this->assertCount(1, $numberOfInspections);
    }


    public function testCars_AddMaintenanceShouldWork()
    {
         // Gives more descriptive errors
         $this->withoutExceptionHandling();
         $this->withoutMiddleware();

         $user = User::factory()->make(['id' => 2, 'company_id' => 2]);

         // Count cars available
         $response = $this->actingAs($user)->get('/car/2/maintenances');
         $numberOfMaintenancesForUser = $response->getOriginalContent()->getData()['maintenances'];

         // Add a car
         $this->actingAs($user)->postJson(route('maintenance.store', [
             'date'=>'2020-10-10',
             'next_maintenance_date'=>'2021-10-10',
             'value'=>100,
             'mileage'=>50000,
             'observations'=>'yearly renewal of maintenance',
             'id'=>2,
         ]));

         // Count car available again
         $addResponse = $this->actingAs($user)->get('/car/2/maintenances');
         $NewNumberOfMaintenancesForUser = $addResponse->getOriginalContent()->getData()['maintenances'];

         // One new maintenance should have been added
         $this->assertEquals(1, count($NewNumberOfMaintenancesForUser) - count($numberOfMaintenancesForUser)); 
    }
    
    public function testCars_AddInsuranceShouldWork()
    {
         // Gives more descriptive errors
         $this->withoutExceptionHandling();
         $this->withoutMiddleware();

         $user = User::factory()->make(['id' => 2, 'company_id' => 2]);

         // Count insurance available
         $response = $this->actingAs($user)->get('/car/2/insurances');
         $numberOfInsurancesForUser = $response->getOriginalContent()->getData()['insurances'];

         // Add a car
         $this->actingAs($user)->postJson(route('insurance.store', [
             'date'=>'2020-10-10',
             'expiration_date'=>'2021-10-10',
             'value'=>100,
             'observations'=>'yearly renewal of insurance',
             'id'=>2,
         ]));

         // Count again
         $addResponse = $this->actingAs($user)->get('/car/2/insurances');
         $NewNumberOfInsurancesForUser = $addResponse->getOriginalContent()->getData()['insurances'];

         // One new should have been added
         $this->assertEquals(1, count($NewNumberOfInsurancesForUser) - count($numberOfInsurancesForUser)); 
    }

    public function testCars_AddTaxShouldWork()
    {
         // Gives more descriptive errors
         $this->withoutExceptionHandling();
         $this->withoutMiddleware();

         $user = User::factory()->make(['id' => 2, 'company_id' => 2]);

         // Count tax available
         $response = $this->actingAs($user)->get('/car/2/taxes');
         $numberOfTaxesForUser = $response->getOriginalContent()->getData()['taxes'];

         $this->actingAs($user)->postJson(route('tax.store', [
             'date'=>'2020-10-10',
             'expiration_date'=>'2021-10-10',
             'value'=>100,
             'observations'=>'yearly renewal of tax',
             'id'=>2,
         ]));

         // Count available again
         $addResponse = $this->actingAs($user)->get('/car/2/taxes');
         $NewNumberOfTaxesForUser = $addResponse->getOriginalContent()->getData()['taxes'];

         // One new should have been added
         $this->assertEquals(1, count($NewNumberOfTaxesForUser) - count($numberOfTaxesForUser)); 
    }

    public function testCars_AddInspectionShouldWork()
    {
         // Gives more descriptive errors
         $this->withoutExceptionHandling();
         $this->withoutMiddleware();

         $user = User::factory()->make(['id' => 2, 'company_id' => 2]);

         // Count inspections available
         $response = $this->actingAs($user)->get('/car/2/inspections');
         $numberOfInspectionsForUser = $response->getOriginalContent()->getData()['inspections'];

         // Add an inspection
         $this->actingAs($user)->postJson(route('inspection.store', [
             'date'=>'2020-10-10',
             'expiration_date'=>'2021-10-10',
             'value'=>100,
             'observations'=>'yearly renewal of inspection',
             'id'=>2,
         ]));

         // Count inspections available again
         $addResponse = $this->actingAs($user)->get('/car/2/inspections');
         $NewNumberOfInspectionsForUser = $addResponse->getOriginalContent()->getData()['inspections'];

         // One new should have been added
         $this->assertEquals(1, count($NewNumberOfInspectionsForUser) - count($numberOfInspectionsForUser)); 
    }

    public function testCars_DeleteMaintenanceShouldWork()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->make(['id' => 1, 'company_id' => 1]);

        // Count maintenances available
        $response = $this->actingAs($user)->get('/car/2/maintenances');
        $numberOfMaintenancesForUser = $response->getOriginalContent()->getData()['maintenances'];

        $firstId = array_key_first(json_decode($numberOfMaintenancesForUser, true));

        // Delete a maintenance
        $delResponse = $this->actingAs($user)->delete(route('maintenance.destroy', ['car_id' => 2, 'maintenance_id' =>  $numberOfMaintenancesForUser[$firstId]['id']]));

        // Count maintenances available again
        $delResponse = $this->actingAs($user)->get('/car/2/maintenances');
        $NewNumberOfMaintenancesForUser = $delResponse->getOriginalContent()->getData()['maintenances'];
        
        $this->assertEquals(1, count($numberOfMaintenancesForUser) - count($NewNumberOfMaintenancesForUser));       
    }

    public function testCars_DeleteTaxShouldWork()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->make(['id' => 1, 'company_id' => 1]);

        // Count tax available
        $response = $this->actingAs($user)->get('/car/2/taxes');
        $numberOfTaxesForUser = $response->getOriginalContent()->getData()['taxes'];

        $firstId = array_key_first(json_decode($numberOfTaxesForUser, true));

        // Delete a tax
        $delResponse = $this->actingAs($user)->delete(route('tax.destroy', ['car_id' => 2, 'tax_id' =>  $numberOfTaxesForUser[$firstId]['id']]));

        // Count taxes available again
        $delResponse = $this->actingAs($user)->get('/car/2/taxes');
        $NewNumberOfTaxesForUser = $delResponse->getOriginalContent()->getData()['taxes'];
        
        $this->assertEquals(1, count($numberOfTaxesForUser) - count($NewNumberOfTaxesForUser));       
    }


    public function testCars_DeleteInsuranceShouldWork()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->make(['id' => 1, 'company_id' => 1]);

        // Count insurances available
        $response = $this->actingAs($user)->get('/car/2/insurances');
        $numberOfInsurancesForUser = $response->getOriginalContent()->getData()['insurances'];

        $firstId = array_key_first(json_decode($numberOfInsurancesForUser, true));

        // Delete a insurance
        $delResponse = $this->actingAs($user)->delete(route('insurance.destroy', ['id' => 2, 'insurance_id' =>  $numberOfInsurancesForUser[$firstId]['id']]));

        // Count insurances available again
        $delResponse = $this->actingAs($user)->get('/car/2/insurances');
        $NewNumberOfInsurancesForUser = $delResponse->getOriginalContent()->getData()['insurances'];
        
        $this->assertEquals(1, count($numberOfInsurancesForUser) - count($NewNumberOfInsurancesForUser));       
    }


    public function testCars_DeleteInspectionShouldWork()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $user = User::factory()->make(['id' => 1, 'company_id' => 1]);

        // Count inspections available
        $response = $this->actingAs($user)->get('/car/2/inspections');
        $numberOfInspectionsForUser = $response->getOriginalContent()->getData()['inspections'];

        $firstId = array_key_first(json_decode($numberOfInspectionsForUser, true));

        // Delete an inspection
        $delResponse = $this->actingAs($user)->delete(route('inspection.destroy', ['car_id' => 2, 'inspection_id' =>  $numberOfInspectionsForUser[$firstId]['id']]));

        // Count inspections available again
        $delResponse = $this->actingAs($user)->get('/car/2/inspections');
        $NewNumberOfInspectionsForUser = $delResponse->getOriginalContent()->getData()['inspections'];
        
        $this->assertEquals(1, count($numberOfInspectionsForUser) - count($NewNumberOfInspectionsForUser));       
    }


}
