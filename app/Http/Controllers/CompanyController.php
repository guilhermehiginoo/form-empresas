<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'            => 'required|string',
            'postcode'        => 'required|string',
            'state'           => 'required|string',
            'city'            => 'required|string',
            'street'          => 'required|string',
            'number'          => 'required|string',
            'neighborhood'    => 'required|string',
            'whatsapp_number' => 'required|string',
            'tax_id'          => [
                'required',
                'string',
                function ($attr, $val, $fail) {
                    $digits = preg_replace('/\D/', '', $val);

                    if (strlen($digits) === 11 && !self::validaCpf($digits)) {
                        return $fail('CPF inválido.');
                    }

                    if (strlen($digits) === 14 && !self::validaCnpj($digits)) {
                        return $fail('CNPJ inválido.');
                    }

                    if (!in_array(strlen($digits), [11, 14])) {
                        return $fail('CPF ou CNPJ inválido.');
                    }
                },
            ],
        ]);

        $categoryId = $request->input('category_id');

        if ($categoryId === 'other') {
            $validatedNew = $request->validate([
                'new_category' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (Category::where('name', $value)->exists()) {
                            $fail("Category \"$value\" already exists");
                        }

                        if (is_numeric($value)) {
                            $fail('Category cannot be numeric.');
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

        auth()->user()->companies()->create([
            ...$data,
            'category_id' => $categoryId,
        ]);

        return back()->with('success', 'Empresa criada com sucesso!');
    }

    private static function validaCpf($cpf)
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;

            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private static function validaCnpj($cnpj)
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $t1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $t2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $s = 0; $i < 12; $i++) {
            $s += $cnpj[$i] * $t1[$i];
        }
        $d1 = ($s % 11) < 2 ? 0 : 11 - ($s % 11);

        for ($i = 0, $s = 0; $i < 13; $i++) {
            $s += $cnpj[$i] * $t2[$i];
        }
        $d2 = ($s % 11) < 2 ? 0 : 11 - ($s % 11);

        return $cnpj[12] == $d1 && $cnpj[13] == $d2;
    }
}
