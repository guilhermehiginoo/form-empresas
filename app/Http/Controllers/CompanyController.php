<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\{RedirectResponse, Request};

class CompanyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Valida os dados da requisição
        $validated = $request->validate([
            'name'            => 'required',
            'postcode'        => 'required',
            'state'           => 'required',
            'city'            => 'required',
            'street'          => 'required',
            'number'          => 'required',
            'neighborhood'    => 'required',
            'whatsapp_number' => 'required',
            'tax_id'          => 'required',
            'category_id'     => 'required|string',
            'new_category'    => [
                'nullable',
                'string',
                'required_if:category_id,other',
                function ($attribute, $value, $fail) {
                    if (Category::where('name', $value)->exists()) {
                        $fail('Category "' . $value . '" already exists.');
                    }
                },
            ],
        ]);

        $categoryId = $validated['category_id'];

        if ($categoryId === 'other') {
            $newCategory = Category::create([
                'name' => $validated['new_category'],
            ]);
            $categoryId = $newCategory->id;
        }

        auth()->user()->companies()->create(array_merge(
            $request->except(['category_id', 'new_category']),
            ['category_id' => $categoryId]
        ));

        return back()->with('success', 'Empresa criada com sucesso!');
    }
}
