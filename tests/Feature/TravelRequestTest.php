<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TravelRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelRequestTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();

        // Cria o usuário padrão
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
        ]);

        // Faz login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => '123456',
        ]);

        // Verifica se o login foi bem-sucedido
        if ($response->status() !== 200) {
            dd('Login falhou:', $response->status(), $response->json());
        }

        $this->token = $response->json('token');
    }

    public function test_can_create_travel_request(): void
    {
        $response = $this->postJson('/api/travel-requests', [
            'requester_name' => 'Armando Mateus',
            'destination' => 'Recife',
            'departure_date' => now()->addDays(3)->toDateString(),
            'return_date' => now()->addDays(5)->toDateString(),
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['destination' => 'Recife']);
    }

    public function test_can_list_travel_requests(): void
    {
        TravelRequest::factory()->count(3)->create([
            'user_id' => User::first()->id,
        ]);

        $response = $this->getJson('/api/travel-requests', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_view_travel_request_by_id(): void
    {
        $travel = TravelRequest::factory()->create([
            'user_id' => User::first()->id,
        ]);

        $response = $this->getJson("/api/travel-requests/{$travel->id}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $travel->id]);
    }

    public function test_owner_cannot_update_status(): void
    {
        $travel = TravelRequest::factory()->create([
            'user_id' => User::first()->id,
        ]);

        $response = $this->patchJson("/api/travel-requests/{$travel->id}/status", [
            'status' => 'aprovado',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(403);
    }

    public function test_can_cancel_approved_travel_request(): void
    {
        $user = User::factory()->create();

        $travel = TravelRequest::factory()->create([
            'user_id' => $user->id,
            'status' => 'aprovado',
        ]);

        $this->actingAs($user, 'api');

        $response = $this->deleteJson("/api/travel-requests/{$travel->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Pedido cancelado com sucesso.']);
    }
}