<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelRequest>
 */
class TravelRequestFactory extends Factory
{
    public function definition(): array
    {
        $departure = $this->faker->dateTimeBetween('+1 days', '+10 days');
        $return = (clone $departure)->modify('+'.rand(2, 7).' days');

        return [
            'user_id' => 1, //  garanta que esse usuário existe no banco
            'requester_name' => $this->faker->name,
            'destination' => $this->faker->city,
            'departure_date' => $departure->format('Y-m-d'),
            'return_date' => $return->format('Y-m-d'),
            'status' => 'solicitado',
        ];
    }
}
