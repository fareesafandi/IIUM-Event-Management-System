<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'matric_no' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role' => ['nullable', Rule::in([User::ROLE_PUBLIC, User::ROLE_EVENT_MANAGER])],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'profile_picture_url' => ['nullable', 'url', 'max:500'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}
