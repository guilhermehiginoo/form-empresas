<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    public function store(): RedirectResponse
    {
        $request = request()->validate([
            'name'            => 'required',
            'postcode'        => 'required',
            'state'           => 'required',
            'city'            => 'required',
            'street'          => 'required',
            'number'          => 'required',
            'neighborhood'    => 'required',
            'whatsapp_number' => 'required',
            'tax_id'          => 'required',
        ]);

        auth()->user()->companies()->create($request);

        return back()->with('success', 'Empresa criada com sucesso!');
    }
}
