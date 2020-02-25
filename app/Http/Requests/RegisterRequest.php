<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Class RegisterRequest
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed']
        ];
    }

    /**
     * @return array
     */
    public function data()
    {
        return array_merge(
            $this->only('name', 'email'), [
                'password' => Hash::make($this->input('password'))
            ]
        );
    }
}
