<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Writer;
use App\Models\User;
use Illuminate\Support\Str;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testBookIndex()
    {
        //comprobamos la ruta
        $response = $this->get('api/books');

        //comprobamos que reciba bien la informacion
        $response->assertStatus(200); 
    }

   
    public function testBookShow()
    {
         



    }

 
    public function testBookStore()
    {
        
        $user = User::factory()->create([
            'role' => 'writer'
        ]);
        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);

        $response = $this->actingAs($user,'api')->post('api/book',[
            'title' => 'Book Name',
            'description' => 'Book description',
            'publish_date' => now(),
            'photo' => null,
            'content' => 'Book content',
            'idwriter' => $writer->idwriter
        ]);
        $response->assertStatus(201);
        $response->assertSee(['Book created successfully']);

    }
    public function testNotAuthorizedCreateBook(){

        $user=user::factory()->create([
            'role' => 'reader'
        ]);
         $response = $this->actingAs($user,'api')->post('api/book',[
            'title' => 'Book Name',
            'description' => 'Book description',
            'publish_date' => now(),
            'photo' => null,
            'content' => 'Book content',
        ]);

        $response->assertStatus(401);
        $response->assertSee('Unauthorized');


    }

 
    public function testBookUpdate()
    {
    }

  
    public function testBookDelete()
    {
    }
}
