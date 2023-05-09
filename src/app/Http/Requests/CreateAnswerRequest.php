<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateAnswerRequest",
 *     type="object",
 *     title="Create Answer Request",
 *     required={"value", "order"},
 *     @OA\Property(property="value", type="string"),
 *     @OA\Property(property="order", type="integer"),
 * )
 */

class CreateAnswerRequest extends FormRequest
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
            'value' => 'required|string',
            'order' => 'required|integer'
        ];
    }
}
