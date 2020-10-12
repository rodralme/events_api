<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Person::factory(10)->create();

         $event = Event::factory()->create();
         $event->organizers()->sync(Person::take(2)->pluck('id'));
         $event->save();
    }
}
