<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_an_event()
    {
        $user = User::factory()->create();
        $user->role=1;

        $this->actingAs($user);

        $eventData = [
            'title' => 'Laracon',
            'description' => 'This is a event description.',
            'date' => '2024-08-02',
            'location' => 'Gujarat',
            'ticket_availability' => 100,
        ];

        $response = $this->post('/events/store', $eventData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('events', [
            'title' => 'Laracon',
        ]);
    }

    /** @test */
    public function a_non_organizer_cannot_create_an_event()
    {
        $user = User::factory()->create();
        $user->role=2;

        $this->actingAs($user);

        $eventData = [
            'title' => 'Laracon',
            'description' => 'This is a event description.',
            'date' => '2024-08-02',
            'location' => 'Gujarat',
            'ticket_availability' => 100,
        ];

        $response = $this->post('/events/store', $eventData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('events', [
            'title' => 'Laracon',
        ]);
    }
}

