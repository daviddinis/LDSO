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
        $this->assertCount(15, $numberOfCarsForUser2);

        //$this->artisan('migrate:fresh');
    }
}
