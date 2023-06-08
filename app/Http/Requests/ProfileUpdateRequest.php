<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name'              => ['string', 'max:255'],
            'unique_numbers'    => ['max_digits:12', 'numeric', Rule::unique(User::class)->ignore($this->user()->id)],
            'gender'            => ['in:male,female'],
            'phone'             => ['numeric', Rule::unique(User::class)->ignore($this->user()->id)],
            'semester'          => ['max_digits:2', 'numeric'],
            'email'             => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
