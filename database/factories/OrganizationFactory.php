<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Organization factory.
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'owner_id' => Client::query()->inRandomOrder()->value('id'),
            'description' => $this->faker->paragraph(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'logo' => $this->faker->imageUrl(200, 200, 'business', true, 'logo'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
