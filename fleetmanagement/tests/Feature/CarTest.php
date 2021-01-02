<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Car;
use App\Company;

use App\Http\Controllers;

class CarTest extends TestCase
{
    //use RefreshDatabase;
    //use DatabaseMigrations;
    //use DatabaseTransactions;

    public function testCars_AccessAddCarPage()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get('/login');

        $getResponse = $this->actingAs($user)->get('/car/create');
        $getResponse->assertViewIs('pages.addCar');
    }

    public function testCars_DashboardShouldShowCorrectAmountOfCarsForUser()
    {
        // Gives more descriptive errors
        $this->withoutExceptionHandling();

        // Seeds our db with data
        //$this->seed();  

        // id 1 is johndoe@fe.up.pt
        // id 2 is johndoe2@fe.up.pt
        $user1 = User::factory()->make(['id' => 1, 'company_id' => 1]);
        $user2 = User::factory()->make(['id' => 2, 'company_id' => 2]);        

        $response1 = $this->actingAs($user1)->get('/car');
        $response2 = $this->actingAs($user2)->get('/car');

        $response1->assertViewIs('pages.cars');
        $response1->assertViewHas('cars');

        $response2->assertViewIs('pages.cars');
        $response2->assertViewHas('cars');

        $numberOfCarsForUser1 = $response1->getOriginalContent()->getData()['cars'];
        $numberOfCarsForUser2 = $response2->getOriginalContent()->getData()['cars'];

        //See seed.sql for correct amount of cars per company
        $this->assertCount(15, $numberOfCarsForUser1);
        $this->assertCount(5, $numberOfCarsForUser2);

        //$this->artisan('migrate:fresh');
    }

    public function testCars_AddCarShouldWork()
    {
         // Gives more descriptive errors
         $this->withoutExceptionHandling();
         $this->withoutMiddleware();

         // Seeds our db with data
         //$this->seed();  

         $user = User::factory()->make(['id' => 2, 'company_id' => 2]);

         // Count cars available
         $response = $this->actingAs($user)->get('/car');
         $numberOfCarsForUser = $response->getOriginalContent()->getData()['cars'];

         // Add a car
         $this->actingAs($user)->postJson(route('car.store', [
             'brand'=>'Volvo',
             'model'=>'XC90',
             'plate'=>'12ABCD',
             'value'=>0,
             'date'=>'2020-10-30',
             'mileage'=>0
         ]));

         // Count car available again
         $addResponse = $this->actingAs($user)->get('/car');
         $NewNumberOfCarsForUser = $addResponse->getOriginalContent()->getData()['cars'];

         // One new car should have been added
         $this->assertEquals(1, count($NewNumberOfCarsForUser) - count($numberOfCarsForUser)); 
    }
}
