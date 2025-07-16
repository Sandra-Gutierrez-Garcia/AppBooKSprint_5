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

    public function testBookIndex()
    {
        $response = $this->get('api/books');
        $response->assertStatus(200); 
    }

    public function testBookShow()
    {
       $user = User::factory()->create();
       $user->roles()->attach(2); 
       $writer = Writer::factory()->create([
            'iduser' => $user->id,
        ]);
        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        $response = $this->get("api/books/{$book->idbook}");
        $response->assertStatus(200); 
    }
    public function testBookShowNotFound()
    {
        $user = User::factory()->create();
        $user->roles()->attach(2); 
        $writer = Writer::factory()->create([
            'iduser' => $user->id,
        ]);
        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        $book->delete();
        $response = $this->get("api/books/{$book->idbook}");
        $response->assertStatus(404);
        $response->assertSee('Book not found');
    }

    public function testBookStore()
    {
        $user = User::factory()->create();
        $user->roles()->attach(2);
        
        $writer = Writer::factory()->create([
            'iduser' => $user->id
        ]);
        //creamos los géneros
        $genre = Genre::factory()->create([
            'namegenre' => 'fantasy',
            'idgenre' => 1
        ]);
        $response = $this->actingAs($user,'api')->post('api/book',[
            'title' => 'Book Name',
            'description' => 'Book description',
            'publish_date' => now(),
            'photo' => null,
            'content' => 'Book content',
            'idwriter' => $writer->idwriter,
            'status' => 'pending',
            'genres' => [$genre->idgenre]
        ]);
        $response->assertStatus(201);
        $response->assertSee(['Book created successfully']);
    }

    public function testNotAuthorizedCreateBook(){
        $user = User::factory()->create();
        $user->roles()->attach(1); 
        $genre = Genre::factory()->create([
            'namegenre' => 'fantasy',
            'idgenre' => 1
        ]);
        $response = $this->actingAs($user,'api')->post('api/book',[
            'title' => 'Book Name',
            'description' => 'Book description',
            'publish_date' => now(),
            'photo' => null,
            'content' => 'Book content',
            'status' => 'pending',
            'genres' => [(int) $genre->idgenre]
        ]);
        $response->assertStatus(401);
        $response->assertSee('Unauthorized');
    }

    public function testBookUpdateStatusNotmodicated()
    {
        $user = User::factory()->create();
        $user->roles()->attach(2); 
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

    public function testBookUpdate()
    {
        $user = User::factory()->create();
        $user->roles()->attach(2); 
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
            'status' => 'completed'
        ]);
        $response->assertStatus(200);
        $response->assertSee('Book updated successfully');
    }

    public function testBookDelete()
    {
         $user = User::factory()->create();
         $user->roles()->attach(2); 
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
        $response = $this->get('/api/books?genre=1');
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'books']);
    }
    
    public function testBookWithoutGenreFilter(){
        $response = $this->get('/api/books');
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'books']);
    }
}