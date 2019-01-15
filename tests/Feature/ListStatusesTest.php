<?php

namespace Tests\Feature;

use App\Models\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListStatusesTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     * 
     * @return void
     */
    public function test_can_get_all_stauses()
    {
    	$this->withoutExceptionHandling();

        $status1 = factory(Status::class)->create(['created_at' => now()->subDays(4)]);
        $status2 = factory(Status::class)->create(['created_at' => now()->subDays(3)]);
        $status3 = factory(Status::class)->create(['created_at' => now()->subDays(2)]);
        $status4 = factory(Status::class)->create(['created_at' => now()->subDays(1)]);

        $response = $this->getJson( route('statuses.index') );

        $response->assertSuccessful();

        $response->assertJson([
        	'total' => 4
        ]);
        $response->assertJsonStructure([
        	'data', 'total', 'first_page_url', 'last_page_url'
        ]);
        //Verifica el ultimo estatus, para el orden descendente.
        $this->assertEquals(
        	$status4->id,
        	$response->json('data.0.id')        	
        );
    }
}
