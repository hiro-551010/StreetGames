<?php

namespace App\Http\Requests;

use App\Models\Team_content;
use Illuminate\Foundation\Http\FormRequest;

class TeamEditRequest extends FormRequest
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
            //
        ];
    }

    public function join(){
        $user_id = $this->user_id;
        $team = Team_content::where('user_id', $user_id)
            ->update(['regular'=>1]);
    }
}
