<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClassificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'code' => __('model.kategori.code'),
            'type' => __('model.kategori.type'),
            'deskripsi' => __('model.kategori.deskripsi'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', Rule::unique('kategoris')],
            'type' => ['required'],
            'deskripsi'=> ['nullable'],
        ];
    }
}
