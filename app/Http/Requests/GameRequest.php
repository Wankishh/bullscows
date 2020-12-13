<?php

namespace App\Http\Requests;

use App\Rules\GameCodeCustomRule;
use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
        $size = config('app.max_allowed_numbers');
        return [
            'input' => ['required', 'regex:/^[0-9]*$/', "size:{$size}", new GameCodeCustomRule()]
        ];
    }
}
