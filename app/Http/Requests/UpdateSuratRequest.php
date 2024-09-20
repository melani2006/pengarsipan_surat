<?php

namespace App\Http\Requests;

use App\Enums\LetterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratRequest extends FormRequest
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
            'nomor_agenda' => __('model.Surat.nomor_agenda'),
            'pengirim' => __('model.Surat.pengirim'),
            'penerima' => __('model.Surat.penerima'),
            'nomor_surat' => __('model.Surat.nomor_surat'),
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
            'nomor_agenda' => ['required'],
            'pengirim' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'penerima' => [Rule::requiredIf($this->type == LetterType::OUTGOING->type())],
            'nomor_surat' => ['required', Rule::unique('surats', 'nomor_surat')->ignore($this->id)],
            'Tanggal_Diterima' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'Tanggal_Surat' => ['required'],
            'deskripsi' => ['required'],
            'Catatan' => ['nullable'],
            'kategori_code' => ['required'],
        ];
    }
}
