<?php

namespace Tests\Feature;

use App\Models\Event;
use Carbon\Carbon;
use Tests\TestCase;

class EventTest extends TestCase
{
    const URI = 'api/events';

    public function testCanRetrieveEventList()
    {
        Event::factory()->count(10)->create();
        $event = Event::factory()->create();
        $event->delete();

        $response = $this->get(self::URI);

        $response->assertStatus(200)
            ->assertJsonCount(10);
    }

    public function testCanCreateNewEvent()
    {
        $start = Carbon::now();
        $response = $this->postJson(self::URI, [
            'title' => 'Event Title',
            'description' => 'A big text',
            'start' => $start,
            'end' => $start->addHour(),
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function testCanReadOneEvent()
    {
        $event = Event::factory()->create();
        $response = $this->get(self::URI . '/' . $event->id);

        $response->assertStatus(200)
            ->assertJson(['id' => $event->id]);
    }

    public function testCanUpdateEvent()
    {
        $start = Carbon::now();
        $response = $this->postJson(self::URI, [
            'title' => 'Event Title',
            'description' => 'A big text',
            'start' => $start,
            'end' => $start->addHour(),
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function testCanDeleteOneEvent()
    {
        $event = Event::factory()->create();
        $response = $this->delete(self::URI . '/' . $event->id);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
