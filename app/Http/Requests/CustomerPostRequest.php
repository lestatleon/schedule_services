<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:255',
            'mobile' => 'required|max:15',
            'isWhatsapp' => 'boolean:strict',
            'phone' => '',
        ];
        // 'tenant_id' => ['required', 'integer', 'exists:tenants,id'],
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A title is absolutely necessary.',
        ];
    }

}
