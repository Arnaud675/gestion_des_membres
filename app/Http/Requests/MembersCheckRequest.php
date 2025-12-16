<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembersCheckRequest extends FormRequest
{
    public function authorize()
    {
        return true; // autoriser la requête
    }

    public function rules()
    {
        return [
            'nom'                   => 'required|string|max:255',
            'prenoms'               => 'required|string|max:255',
            'date_naissance'        => 'required|date',
            'lieu_naissance'        => 'required|string|max:255',
            'nom_pere'              => 'nullable|string|max:255',
            'nom_mere'              => 'nullable|string|max:255',
            'profession'            => 'nullable|string|max:255',
            'nationalite'           => 'nullable|string|max:255',
            'situation_matrimoniale'=> 'nullable|string|max:50',
            'adresse'               => 'nullable|string|max:500',
            'photo'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nom.required'                  => 'Le nom est obligatoire.',
            'prenoms.required'              => 'Les prénoms sont obligatoires.',
            'date_naissance.required'       => 'La date de naissance est obligatoire.',
            'lieu_naissance.required'       => 'Le lieu de naissance est obligatoire.',
            'photo.image'                   => 'Le fichier doit être une image.',
            'photo.max'                     => 'La photo ne doit pas dépasser 2 MB.',
        ];
    }
}
