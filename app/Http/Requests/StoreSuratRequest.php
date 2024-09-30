<?php

namespace App\Http\Requests;

use App\Enums\LetterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSuratRequest extends FormRequest
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
            'kegiatan' => 'kegiatan',
            'pengirim' => 'pengirim',
            'penerima' => 'penerima',
            'nomor_surat' => 'nomor_surat',
            'tanggal_diterima' => 'tanggal_diterima',
            'tanggal_surat' => 'tanggal_surat',
            'deskripsi' => 'deskripsi',
            'catatan' => 'catatan',
            'kategori_code' => 'kategori_code',
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
            'kegiatan' => ['required'],
            'pengirim' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'penerima' => [Rule::requiredIf($this->type == LetterType::OUTGOING->type())],
            'type' => ['required'],
            'nomor_surat' => ['required', Rule::unique('surats')],
            'tanggal_diterima' => [Rule::requiredIf($this->type == LetterType::INCOMING->type())],
            'tanggal_surat' => ['required'],
            'deskripsi' => ['required'],
            'catatan' => ['nullable'],
            'kategori_code' => ['required'],
        ];
    }
}
