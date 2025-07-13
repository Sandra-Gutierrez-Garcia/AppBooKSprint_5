<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Writer;
use App\Models\User;
use Illuminate\Support\Str;

class WriterControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function testWriterIndex()
    {        
        $user = User::factory()->create([
            'role' => 'writer'
        ]);

        $writer = Writer::factory()->create([
        'iduser' => $user->id
    ]);

        $this->assertEquals('writer', $user->role);

        $response = $this->actingAs($user, 'api')->get('api/writers');
        $response->assertStatus(200); 
        $response->assertJson(['message' => 'List of writers']);

    }


    public function testWriterShow()
    {
        $user = User::factory()->create([
            'role' => 'writer'
        ]);

        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);

        $response = $this->actingAs($user, 'api')->get("api/writers/{$writer->idwriter}");
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Writer found']);
    }

 
    public function testWriterStore()
    {
         $user = User::factory()->create([
            'role' => 'writer'
        ]);
        $response = $this->actingAs($user, 'api')->post('api/writers',[
            'name' => 'Writer Name',
            'biography' => 'writer biography',
            'photo' => null,
            'iduser' => $user->id
        ]);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Author created successfully']);


       
    }

  
    public function testWriterUpdate()
    {
        // Create a user and a writer for testing
        $user = User::factory()->create([
            'role' => 'writer'
        ]);

        // Create a writer associated with the user
        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);
        $response = $this->actingAs($user, 'api')->put("api/writers/{$writer->idwriter}", [
            'name' => 'Updated Writer Name',
            'biography' => 'Updated biography',
            'photo' => null,
        ]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Writer updated successfully']);
    }

    
    public function testWriterDelete()
    {
        // Create a user for testing
         $user = User::factory()->create([
            'role' => 'writer'
        ]);

        // Create a writer associated with the user
        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);
        $response = $this->actingAs($user, 'api')->delete("api/writers/{$writer->idwriter}");
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Writer deleted successfully']);
    }
}
