<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisposisiRequest extends FormRequest
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
            'penerima' => __('model.disposisi.penerima'),
            'content' => __('model.disposisi.content'),
            'batas_waktu' => __('model.disposisi.batas_waktu'),
            'status_surat' => __('model.dispossi.status'),
            'catatan' => __('model.disposisi.catatan'),
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
            'penerima' => ['required'],
            'content' => ['required'],
            'batas_waktu' => ['required'],
            'status_surat' => ['required'],
            'catatan' => ['nullable'],
        ];
    }
}
