<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Writer;
use App\Models\User;
use App\Models\Genre;
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
       $user = User::factory()->create([
            'role' => 'writer'
        ]);
        $writer = Writer::factory()->create([
            'iduser' => $user->id,
        ]);

        $book = Book::factory()->create(
            ['idwriter' => $writer]);
        $response = $this->get("api/books/{$book->idbook}");
        $response->assertStatus(200); 
    }
    public function testBookShowNotFound()
    {
        $user = User::factory()->create([
            'role' => 'writer'
        ]);
        $writer = Writer::factory()->create([
            'iduser' => $user->id,
        ]);

        $book = Book::factory()->create(
            ['idwriter' => $writer]);
        
        $book->delete();

        $response = $this->get("api/books/{$book->idbook}");
        $response->assertStatus(404);
        $response->assertSee('Book not found');
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

        $user = User::factory()->create([
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
        $user = User::factory()->create([
            'role' => 'writer'
        ]);

        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);

        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);

         $response = $this->actingAs($user,'api')->put("api/book/{$book->idbook}",[
            'title' => 'Book Name updated',
            'description' => 'Book description updated',
            'publish_date' => now(),
            'photo' => null,
            'content' => 'Book content updated',
        ]);
        $response->assertStatus(200);
        $response->assertSee('Book updated successfully');
    }

  
    public function testBookDelete()
    {
         $user = User::factory()->create([
            'role' => 'writer'
        ]);

        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);

        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        $response = $this->actingAs($user,'api')->delete("api/book/{$book->idbook}");
        $response->assertStatus(200);
        $response->assertSee('Book deleted successfully');
    }
   
    public function testBookFilter(){
        // Test filtering books by genre
        $response = $this->get('/api/books?genre=1');
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'books']);
    }
    
    public function testBookWithoutGenreFilter(){
        // Test without genre filter (should return all books)
        $response = $this->get('/api/books');
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'books']);
}
}