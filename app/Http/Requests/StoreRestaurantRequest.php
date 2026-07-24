<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // L'utilisateur est déjà vérifié par le middleware 'auth'
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address'     => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'logo'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Max 2Mo
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du restaurant est obligatoire.',
            'logo.image'    => 'Le fichier doit être une image.',
            'logo.max'      => 'L\'image du logo ne doit pas dépasser 2 Mo.',
        ];
    }
}