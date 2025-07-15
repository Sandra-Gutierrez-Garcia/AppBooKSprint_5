<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    //Test for index function and route
    public function testUserIndexForWriter(){
        $user = User::factory()->create([
            'role' => 'writer',        
        ]);
        $this->assertEquals('writer', $user->role);
        //comprovamos el Api
        $response = $this->actingAs($user, 'api')->get('api/users');
        $response->assertStatus(202); 
    }


    public function testUserIndexForReader (){
        $response = User::factory()->create([
            'role' => 'reader',        
        ]);
        $this->assertEquals('reader', $response->role);
    }


    public function testruts(){
        $user = User::factory()->create();
        $responseRutaIndix = $this->actingAs($user, 'api')->get('api/users');
        $responseRutaIndix->assertStatus(201); 
    }

    //test for show function and route
    public function testUserShowForWriter(){
        $user = user::factory()->create([
            'role'=>'writer',
        ]);
        $responseRutaIndix = $this->actingAs($user, 'api')->get("api/users/{$user->id}");
        $responseRutaIndix->assertStatus(403);
        $responseRutaIndix->assertSee('Access denied for writers');
    }
    public function  testUpdateUser(){
        $user = User::factory()->create([
            'role' => 'writer'
        ]);
        $response = $this->actingAs($user, 'api')->put("api/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
        ]);
        $response->assertStatus(200);
        $response->assertSee('User updated successfully');
    }
}
