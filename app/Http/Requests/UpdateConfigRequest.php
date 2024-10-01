<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->role == Role::ADMIN->status();
    }

    public function attributes(): array
    {
        return [
            'password' => 'password',
            'nama_aplikasi' => 'nama_aplikasi',
            'nama_institusi' => 'nama_institusi',
            'alamat_institusi' => 'alamat_institusi',
            'telepon_institusi' => 'telepon_institusi',
            'email_institusi' => 'email_institusi',
            'penanggung_jawab' => 'penanggung_jawab',
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
            'password' => ['required'],
            'nama_aplikasi' => ['required'],
            'nama_institusi' => ['required'],
            'alamat_institusi' => ['required'],
            'telepon_institusi' => ['required'],
            'email_institusi' => ['required'],
            'penanggung_jawab' => ['required'],
        ];
    }
}
