<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ChatRequest
 * @package App\Http\Requests
 */
class ChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($chat = $this->route('chat')) {
            return $this->user()->can('update', $chat);
        }

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
            'users' => 'array',
            'users.*' => ['required', 'integer', Rule::exists('users', 'id')]
        ];
    }
}
