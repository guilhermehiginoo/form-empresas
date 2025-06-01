<?php

namespace Database\Factories;

use App\Models\{Category, Company, User};
use Faker\Provider\pt_BR\{Company as fakerCompany, Person, PhoneNumber};
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        // Registra providers pt_BR
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new PhoneNumber($this->faker));
        $this->faker->addProvider(new fakerCompany($this->faker));

        return [
            'name'            => $this->faker->company(),
            'postcode'        => $this->faker->postcode(),
            'state'           => $this->faker->state(),
            'city'            => $this->faker->city(),
            'neighborhood'    => $this->faker->streetName(),
            'street'          => $this->faker->streetName(),
            'number'          => $this->faker->buildingNumber(),
            'tax_id'          => $this->faker->cnpj(false),
            'whatsapp_number' => $this->faker->cellphone(),
            'user_id'         => User::factory(),
            'category_id'     => Category::factory(),
        ];
    }
}
