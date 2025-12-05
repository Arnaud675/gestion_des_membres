<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembersCheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:members,email',
            'phone'  => 'nullable|string|max:20',
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Le nom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email'    => 'L’email doit être valide.',
            'email.unique'   => 'Cet email est déjà utilisé.',
            'photo.image'    => 'La photo doit être une image.',
            'photo.mimes'    => 'La photo doit être au format jpg, jpeg ou png.',
            'photo.max'      => 'La photo ne doit pas dépasser 2 Mo.',
        ];
    }
}


