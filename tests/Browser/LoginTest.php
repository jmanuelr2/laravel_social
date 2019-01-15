<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function registred_users_can_login()
    {
        factory(User::class)->create(['email' => 'jorge@email.com']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email','jorge@email.com')
                    ->type('password', 'secret')
                    ->press('#login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated()
                ;
        });
    }
}
