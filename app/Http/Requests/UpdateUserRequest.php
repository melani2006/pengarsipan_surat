<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Hanya admin yang dapat mengubah data user, atau user yang sedang login
        return auth()->user()->role == Role::ADMIN->status() || $this->id == auth()->user()->id;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email',
            'phone' => 'phone',
            'password' => 'password',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required', Rule::unique('users')->ignore($this->id)],
            'phone' => ['required', 'numeric'],
            'is_active' => ['nullable'],
        ];

        // Hanya admin yang dapat mengubah password
        if (auth()->user()->role == Role::ADMIN->status() && $this->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        return $rules;
    }
}
