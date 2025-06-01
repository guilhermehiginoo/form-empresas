<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $categoryId = $request->input('category_id');

        if ($categoryId === 'other') {
            $validatedNew = $request->validate([
                'new_category' => [
                    'required',
                    'string',
                    function ($attr, $val, $fail) {
                        if (Category::where('name', $val)->exists()) {
                            $fail("Category \"$val\" already exists");
                        }
                    },
                ],
            ]);

            $categoryId = Category::create([
                'name' => $validatedNew['new_category'],
            ])->id;
        } else {

            $request->validate([
                'category_id' => [
                    'required',
                    'integer',
                    Rule::exists('categories', 'id'),
                ],
            ]);
        }

        $data = $request->validate([
            'name'            => 'required|string',
            'postcode'        => 'required|string',
            'state'           => 'required|string',
            'city'            => 'required|string',
            'street'          => 'required|string',
            'number'          => 'required|string',
            'neighborhood'    => 'required|string',
            'whatsapp_number' => 'required|string',
            'tax_id'          => 'required|string',
        ]);

        auth()->user()->companies()->create([
            ...$data,
            'category_id' => $categoryId,
        ]);

        return back()->with('success', 'Empresa criada com sucesso!');
    }
}
