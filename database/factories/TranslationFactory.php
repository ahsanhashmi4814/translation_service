<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->uuid, // Use uuid to guarantee uniqueness
            'value' => $this->faker->sentence,
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'tags' => $this->faker->randomElement(['mobile', 'desktop', 'web']),
        ];
    }
}
