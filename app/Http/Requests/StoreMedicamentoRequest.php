<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentoRequest extends FormRequest
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
            'nome_comercial' => ['required', 'string', 'max:255'],
            'id_principio_ativo' => ['nullable', 'exists:principio_ativo,id_principio_ativo'],
            'id_classificacao' => ['nullable', 'exists:classificacao_medicamento,id_classificacao'],
            'id_sintomatologia' => ['nullable', 'exists:sintomatologia,id_sintomatologia'],
            'id_alt_lab' => ['nullable', 'exists:alteracao_laboratorial,id_alt_lab'],
            'id_interacao' => ['nullable', 'exists:interacao,id_interacao'],
            'id_acao_med' => ['nullable', 'exists:acao_medicina,id_acao_med'],
            'id_acao_nut' => ['nullable', 'exists:acao_nutricao,id_acao_nut'],
            'id_acao_enf' => ['nullable', 'exists:acao_enfermagem,id_acao_enf'],
            'observacoes' => ['nullable', 'string'],
        ];
    }
}
