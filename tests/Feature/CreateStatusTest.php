<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
	use RefreshDatabase;
	//notación test para precendir del prefijo test en todod los metodos
    
    public function test_guests_users_can_not_create_statuses()
    {
    	//$this->withoutExceptionHandling();
    	$response = $this->post(route('statuses.store'),['body' => 'Mi primer status']);

    	//dd($response->content());
    	$response->assertRedirect('login');	
    }

    public function test_a_authenticated_user_can_create_statuses()
    {
    	$this->withoutExceptionHandling();
        //1. Given => Teniendo -> Estado de la aplicación antes de realizar la acción que queremos probar
        // Teniendo un usuario autenticado
        $user = factory(User::class)->create();
        $this->actingAs($user);
        //2. When => cuando -> Realizamos la acción que queremos probar
        // Cuando hace un post request a status
        $response = $this->postJson(route('statuses.store'),['body' => 'Mi primer status']);

        $response->assertJson([
        	'body' => 'Mi primer status'
        ]);


        //3. Then -> comprobamos que los resultados sean los esperados
        //Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses',[
        	'user_id' => $user->id,
        	'body' => 'Mi primer status'
        ]);

    }
    public function test_a_status_require_a_body()
    {    
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => '']);         	

        //dd($response->content());
        $response->assertStatus(422);

        $response->assertJsonStructure([
        	'message', 'errors' => ['body']
        ]);
    }
    public function test_a_status_require_a_minimun_length()
    {    
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => 'asdf']);         	

        //dd($response->content());
        $response->assertStatus(422);

        $response->assertJsonStructure([
        	'message', 'errors' => ['body']
        ]);
    }

}
