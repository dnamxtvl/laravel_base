<?php

namespace App\Http\Requests;

use App\Operations\RespondWithJsonErrorTraitOperation;
use Illuminate\Foundation\Http\FormRequest;

class BlockUserRequest extends FormRequest
{
    use RespondWithJsonErrorTraitOperation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'to_user_id' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'to_user_id.integer' => 'UserId phải là số!',
            'to_user_id.required' => 'UserId đang để trống'
        ];
    }
}
