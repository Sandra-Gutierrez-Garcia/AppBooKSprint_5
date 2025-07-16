<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Writer;
use App\Models\User;
use App\Models\BookLike;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    //Test for index function and route
    public function testUserIndexForWriter(){
        $user = User::factory()->create();
        $user->roles()->attach(2);
        
        $response = $this->actingAs($user, 'api')->get('api/users');
        $response->assertStatus(202); 
    }


    public function testUserIndexForReader (){

        $user = User::factory()->create();
        $user->roles()->attach(1); 

        $response = $this->actingAs($user, 'api')->get('api/users');
        $response->assertStatus(201); 
    }


    public function testruts(){

        $user = User::factory()->create();

        $responseRutaIndix = $this->actingAs($user, 'api')->get('api/users');
        $responseRutaIndix->assertStatus(201); 
    }

    //test for show function and route
    public function testUserShowForWriter()
    {
        $user = User::factory()->create();
        $user->roles()->attach(2); 

        $responseRutaIndix = $this->actingAs($user, 'api')->get("api/users/{$user->id}");

        $responseRutaIndix->assertStatus(403);
        $responseRutaIndix->assertSee('Access denied for writers');
    }
    public function  testUpdateUser(){

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->put("api/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
        ]);
        $response->assertStatus(200);
        $response->assertSee('User updated successfully');
    }
    
    public function  testDelateUser(){
            
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->delete("api/users/{$user->id}"); 
           
        $response->assertStatus(200);
        $response->assertSee('User deleted successfully');
    }
    
    public function testAddlike(){
        $user = User::factory()->create();
        $user->roles()->attach(1); 

        $writerUser = User::factory()->create();
        $writerUser->roles()->attach(2);
        
        $writer = Writer::factory()->create([
            'iduser' => $writerUser->id
        ]);
        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        
        $response = $this->actingAs($user, 'api')->post("api/books/{$book->idbook}/like");
        $response->assertStatus(200);
        $response->assertSee('Book liked successfully');
    }
    public function testRemoveLike(){
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $writerUser = User::factory()->create();
        $writerUser->roles()->attach(2); 

        $writer = Writer::factory()->create([
            'iduser' => $writerUser->id
        ]);
        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        $BookLike = BookLike::factory()->create([
            'idbook' => $book->idbook,
            'iduser' => $user->id
        ]);

        $response = $this->actingAs($user, 'api')->delete("api/books/{$book->idbook}/like");
        $response->assertStatus(200);
    }
    public function testSeelikedBooks()
    {
        $user = User::factory()->create();
        $user->roles()->attach(1); 

        $writerUser = User::factory()->create();
        $writerUser->roles()->attach(2); 
        
        $writer = Writer::factory()->create([
            'iduser' => $writerUser->id
        ]);
        $book = Book::factory()->create([
            'idwriter' => $writer->idwriter
        ]);
        BookLike::factory()->create([
            'idbook' => $book->idbook,
            'iduser' => $user->id
        ]);
        $response = $this->actingAs($user, 'api')->get('api/book/liked');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                '*' => [
                    'idbook',
                    'title'
                ]
            ]
        ]);
    }
}
