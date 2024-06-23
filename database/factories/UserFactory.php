<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            'fk_role' => fake()->numberBetween(1, 3),
            'fk_gender' => fake()->numberBetween(1, 2),
            'suspended' => false,
            'birthdate' => fake()->date(),
            'contact_number' => str_pad(rand(0, 99_999_999_999), 11, "0", STR_PAD_LEFT),
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'company_id' => 'HP-' . str_pad(fake()->numberBetween(1, 2000), 4, "0", STR_PAD_LEFT),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
