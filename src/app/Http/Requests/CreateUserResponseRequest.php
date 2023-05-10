<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateUserResponseRequest",
 *     type="object",
 *     title="Create User Response Request",
 *     properties={
 *         @OA\Property(property="respondent_ident", type="string"),
 *         @OA\Property(property="answer", type="string"),
 *     },
 *     required={"respondent_ident", "answer"},
 * )
 */


class CreateUserResponseRequest extends FormRequest
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
            'respondent_ident' => 'required|string',
            'answer' => 'required|string'
        ];
    }
}
