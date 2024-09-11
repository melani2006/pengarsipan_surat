<?php

namespace App\Http\Requests;

use App\Enums\LetterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLetterRequest extends FormRequest
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
            'nomor_surat' => __('model.Surat.nomor_surat'),
            'Tanggal_Diterima' => __('model.Surat.Tanggal_Diterima'),
            'Tanggal_Surat' => __('model.Surat.Tanggal_Surat'),
            'deskripsi' => __('model.Surat.deskripsi'),
            'Catatan' => __('model.Surat.Catatan'),
            'classification_code' => __('model.Surat.classification_code'),
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
            'type' => ['required'],
            'nomor_surat' => ['required', Rule::unique('surats')],
            'Tanggal_Diterima' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'Tanggal_Surat' => ['required'],
            'deskripsi' => ['required'],
            'Catatan' => ['nullable'],
            'classification_code' => ['required'],
        ];
    }
}
