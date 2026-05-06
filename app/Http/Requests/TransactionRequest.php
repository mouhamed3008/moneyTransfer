<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:depot,retrait,transfert',
            'montant' => 'required|numeric|min:100',
            'numero_compte_destinaire' => 'required|string|exists:accounts,numero_compte',
            'numero_compte_emetteur' => 'required|string|exists:accounts,numero_compte',
        ];
    }


    public function messages(): array
    {
        return [
            'type.required' => 'Le type de transaction est requis.',
            'type.in' => 'Le type de transaction doit être soit "depot", "retrait" ou "transfert".',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au moins 100 FCFA.',
            'numero_compte_destinaire.required' => 'Le numéro de compte destinataire est requis.',
            'numero_compte_destinaire.string' => 'Le numéro de compte destinataire doit être une chaîne de caractères.',
            'numero_compte_destinaire.exists' => 'Le numéro de compte destinataire doit exister dans la base de données.',
            'numero_compte_emetteur.required' => 'Le numéro de compte émetteur est requis.',
            'numero_compte_emetteur.string' => 'Le numéro de compte émetteur doit être une chaîne de caractères.',
            'numero_compte_emetteur.exists' => 'Le numéro de compte émetteur doit exister dans la base de données.',
        ];
    }
}
