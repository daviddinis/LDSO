<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Carbon\Carbon;

class LaravelDuskTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testSiteUp()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->assertSee('iFleet');
        });
    }

    public function testBasicLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->assertSee('Dashboard')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testUserSignup()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->click('div.row:nth-child(9) > div:nth-child(2) > h6:nth-child(1) > a:nth-child(1)')
                    ->assertSee('Register')
                    ->value('#name', 'testname')
                    ->value('#company_name', 'testcompany')
                    ->value('#email', 'testmail@mail.com')
                    ->value('#password', '12345678')
                    ->value('#password_confirmation', '12345678')
                    ->click('.btn')
                    ->assertSee('testname')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddCar()
    { 
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('a.btn')
                    ->value('#brand', 'Car1')
                    ->value('#model', 'Carbrand1')
                    ->value('#plate', '12ABCD')
                    ->keys('#date', '10101990')
                    ->value('#mileage','100')
                    ->value('#mileage','100')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Car1 Carbrand1')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddDriver()
    { 
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('li.nav-item:nth-child(3) > a:nth-child(1)')
                    ->assertSee('DriverLicense')
                    ->click('.btn-primary')
                    ->value('#name', 'DriverFirstName')
                    ->value('#email', 'Driver@driving.com')
                    ->value('#drivers_license', '123456789')
                    ->value('#id_card', '12')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('DriverFirstName')
                    ->assertSee('Driver@driving.com')
                    ->assertSee('123456789')
                    ->assertSee('12')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAssignDriver()
    {        
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('#carTable > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(1) > a:nth-child(1)')
                    ->assertSee('Last used by')
                    ->assertSee('Car is available!')
                    ->click('button.btn-primary:nth-child(1)')
                    ->pause(1000)
                    ->select('#driver_id', '3')
                    ->keys('#end_date', '10102100')                  
                    ->click('button.btn-primary:nth-child(2)')
                    ->assertSee('In use by')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddAndDeleteAndEditMaintenance()
    {        
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('#carTable > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(1) > a:nth-child(1)')
                    ->click('div.row:nth-child(5) > div:nth-child(1) > a:nth-child(1)')
                    ->click('.fa-plus')
                    ->keys('#date', '10102018')
                    ->keys('#next_maintenance_date', '10102021')
                    ->value('#value', '139')
                    ->value('#mileage', '15000')
                    ->value('#observations', 'Observation added by test')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Observation added by test')
                    ->click('.card-header > form:nth-child(1) > button:nth-child(3) > i:nth-child(1)')
                    ->acceptDialog()
                    ->assertDontSee('Steering')
                    ->click('tr.table-primary:nth-child(2) > td:nth-child(8) > a:nth-child(2) > i:nth-child(1)')
                    ->value('#observations', 'Edited observation')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Edited observation')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddAndDeleteAndEditInsurance()
    {        
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('#carTable > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(1) > a:nth-child(1)')
                    ->click('div.row:nth-child(5) > div:nth-child(2) > a:nth-child(1)')
                    ->click('.fa-plus')
                    ->keys('#date', '10102018')
                    ->keys('#expiration_date', '10102021')
                    ->value('#value', '139')
                    ->value('#observations', 'Observation added by test')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Observation added by test')
                    ->click('.card-header > form:nth-child(1) > button:nth-child(3) > i:nth-child(1)')
                    ->acceptDialog()
                    ->assertDontSee('Steering')
                    ->click('.fa-pencil')
                    ->value('#observations', 'Edited observation')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Edited observation')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddAndDeleteAndEditTax()
    {        
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('#carTable > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(1) > a:nth-child(1)')
                    ->click('div.col:nth-child(3) > a:nth-child(1)')
                    ->click('.fa-plus')
                    ->keys('#date', '10102018')
                    ->keys('#expiration_date', '10102021')
                    ->value('#value', '139')
                    ->value('#obs', 'Observation added by test')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Observation added by test')
                    ->click('button.btn:nth-child(3)')
                    ->acceptDialog()
                    ->assertDontSee('Steering')
                    ->click('.fa-pencil')
                    ->value('#obs', 'Edited observation')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Edited observation')
                    ->deleteCookie('app_session_cookie');
                });
    }

    public function testAddAndDeleteAndEditInspection()
    {        
        $this->browse(function (Browser $browser) {
            $browser->visit('http://ifleet.dusk.test/')
                    ->value('#email', 'johndoe@fe.up.pt')
                    ->value('#password', '1234')
                    ->click('.btn')
                    ->click('#carTable > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(1) > a:nth-child(1)')
                    ->click('div.col:nth-child(4) > a:nth-child(1)')
                    ->click('.fa-plus')
                    ->keys('#date', '10102018')
                    ->keys('#expiration_date', '10102021')
                    ->value('#value', '139')
                    ->value('#observations', 'Observation added by test')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Observation added by test')
                    ->click('.card-header > form:nth-child(1) > button:nth-child(3) > i:nth-child(1)')
                    ->acceptDialog()
                    ->assertDontSee('Steering')
                    ->click('.card-header > a:nth-child(2) > i:nth-child(1)')
                    ->value('#observations', 'Edited observation')
                    ->click('button.btn:nth-child(1)')
                    ->assertSee('Edited observation')
                    ->deleteCookie('app_session_cookie');
                });
    }
    
}
