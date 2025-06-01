<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\{RedirectResponse};

class CategoryController extends Controller
{
    public function store(): RedirectResponse
    {
        $request = request()->validate([
            'category' => 'required|string',
        ]);

        // Cria a nova categoria
        Category::create([
            'name' => $request['category'],
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    public function index()
    {
        return response()->json(Category::all());
    }
}
