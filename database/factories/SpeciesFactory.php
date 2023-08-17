<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpeciesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'kingdom' => $this->faker->word(),
            'phylum' => $this->faker->word(),
            'class' => $this->faker->word(), // password
            'order' => $this->faker->word(),
            'family' => $this->faker->words(2, true),
            'genus' => $this->faker->words(2, true),
            'species' => $this->faker->words(2, true),
            'common_name' => $this->faker->name(),
            'local_name' => $this->faker->name(),
            'country' => $this->faker->country(),
            'environment' => $this->faker->catchPhrase(),
            'general_description' => $this->faker->catchPhrase(),
            'iucn_status' => $this->faker->word(),
            'threats_to_humans' => $this->faker->word(),
            'economic_values_uses' => $this->faker->word(),
            'references' =>  $this->faker->text(200),
        ];
    }
}
