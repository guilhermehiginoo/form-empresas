<?php

use App\Models\{Category, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use function Pest\Laravel\{actingAs, post};

it('should be able to create a new company', function () {
    $user     = User::factory()->create();
    $category = Category::factory()->create();
    actingAs($user);

    $response = post(route('company.store'), [
        'category_id' => $category->id,
    ]);

    $response->assertSessionHasErrors([
        'name',
        'postcode',
        'state',
        'city',
        'street',
        'number',
        'neighborhood',
        'whatsapp_number',
        'tax_id',
    ]);
});
