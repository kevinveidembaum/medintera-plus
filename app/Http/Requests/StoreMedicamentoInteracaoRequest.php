<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicamentoInteracaoRequest extends FormRequest
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
            'medicamento_origem' => ['required', 'exists:medicamento,id_medicamento'],
            'medicamento_alvo' => ['required', 'exists:medicamento,id_medicamento', 'different:medicamento_origem'],
            'id_interacao' => ['nullable', 'exists:interacao,id_interacao'],
            'severidade' => ['required', 'string', 'in:Leve,Moderada,Grave,Fatal'],
            'descricao' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'medicamento_alvo.different' => 'Um medicamento não pode ter uma interação com ele mesmo.',
        ];
    }
}
