<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDispositionRequest extends FormRequest
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
            'to' => __('model.disposisi.to'),
            'content' => __('model.disposisi.content'),
            'due_date' => __('model.disposisi.due_date'),
            'status_surat' => __('model.dispossi.status'),
            'Catatan' => __('model.disposisi.Catatan'),
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
            'to' => ['required'],
            'content' => ['required'],
            'due_date' => ['required'],
            'status_surat' => ['required'],
            'Catatan' => ['nullable'],
        ];
    }
}
