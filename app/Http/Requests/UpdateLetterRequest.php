<?php

namespace App\Http\Requests;

use App\Enums\LetterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLetterRequest extends FormRequest
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
            'agenda_number' => __('model.Surat.agenda_number'),
            'from' => __('model.Surat.from'),
            'penerima' => __('model.Surat.penerima'),
            'reference_number' => __('model.Surat.reference_number'),
            'Tanggal_Diterima' => __('model.Surat.Tanggal_Diterima'),
            'Tanggal_Surat' => __('model.Surat.Tanggal_Surat'),
            'deskripsi' => __('model.Surat.deskripsi'),
            'Catatan' => __('model.Surat.Catatan'),
            'kategori_code' => __('model.Surat.kategori_code'),
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
            'agenda_number' => ['required'],
            'from' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'penerima' => [Rule::requiredIf($this->type == LetterType::OUTGOING->type())],
            'reference_number' => ['required', Rule::unique('surats', 'reference_number')->ignore($this->id)],
            'Tanggal_Diterima' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'Tanggal_Surat' => ['required'],
            'deskripsi' => ['required'],
            'Catatan' => ['nullable'],
            'kategori_code' => ['required'],
        ];
    }
}
