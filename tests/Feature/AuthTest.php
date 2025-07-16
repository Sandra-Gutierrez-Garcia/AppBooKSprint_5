<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\PersonalAccessClient;
use Illuminate\Support\Facades\Artisan;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Verifica si el cliente personal de Passport ya existe.
        Artisan::call('passport:client', [ // Comando para crear un cliente personal de Passport.
            '--personal' => true,// Esto es necesario para que la autenticación con tokens funcione correctamente en el entorno de pruebas.
            '--name' => 'Test Personal Access Client', // Nombre del cliente personal que se creará.
            '--provider' => config('auth.guards.api.provider'), // Proveedor de usuarios que se utilizará para este cliente.
        ]);
    }

    /**
     * Test registration route.
     */
    public function test_register()
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200); // Espera respuesta exitosa de la API
        $this->assertArrayHasKey('token', $response->json());
    }
    public function test_login()
    {
        // Primero, registra un usuario para poder iniciar sesión.
        $registerResponse = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        // Ahora, intenta iniciar sesión con las credenciales del usuario registrado.
        $response = $this->post('/api/login', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200); 
        $this->assertArrayHasKey('token', $response->json()); 
    }
    public function test_logout(){
        $registerResponse = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $loginResponse = $this->post('/api/login', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);
        $token = $loginResponse->json('token');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout');
        $response->assertStatus(200);
    }
}
