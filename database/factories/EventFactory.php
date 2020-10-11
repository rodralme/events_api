<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-30 days', '+30 days');
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->optional()->text,
            'start' => $start,
            'end' => Carbon::parse($start)->addMinutes(rand(10, 360)),
        ];
    }
}
