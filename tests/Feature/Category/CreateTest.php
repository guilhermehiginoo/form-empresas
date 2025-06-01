<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use function Pest\Laravel\{actingAs, post};

it('should be able to create a new category', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = post(route('category.store'), [
        'category' => 'Nova Categoria',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('categories', [
        'name' => 'Nova Categoria',
    ]);
});
