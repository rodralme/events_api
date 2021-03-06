<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Person;
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

    public function testCanCreateEvent()
    {
        $data = Event::factory()->make()->toArray();
        $data['organizers'] = Person::factory(1)->create()->pluck('id');
        $response = $this->postJson(self::URI, $data);

        $response->assertStatus(201)
            ->assertJson(['success' => true]);

        self::assertTrue(Event::find($response->json('data')['id'])->organizers()->exists());
    }

    public function testCannotCreateEventWithInvalidOrganizers()
    {
        $data = Event::factory()->make()->toArray();
        $data['organizers'] = [999];
        $response = $this->postJson(self::URI, $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['organizers']);
    }

    public function testCanReadEvent()
    {
        $event = Event::factory()->create();
        $response = $this->get(self::URI . '/' . $event->id);

        $response->assertStatus(200)
            ->assertJson(['id' => $event->id]);
    }

    public function testCanUpdateEvent()
    {
        $event = Event::factory()->create();

        $data = Event::factory()->make()->toArray();
        $data['organizers'] = Person::factory(2)->create()->pluck('id');

        $response = $this->putJson(self::URI . '/' . $event->id, $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $event->refresh();
        self::assertTrue($event->organizers()->exists());
    }

    public function testCanDeleteEvent()
    {
        $event = Event::factory()->create();
        $response = $this->delete(self::URI . '/' . $event->id);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $event->refresh();
        self::assertTrue($event->trashed());
    }
}
