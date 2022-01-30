<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Team_content;

class TeamJoinRequest extends FormRequest
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

    public function team_join(){
        $posts = $this->all();
        $team = new Team_content;
        $team->create(['team_id'=>$posts['team_id'], 'user_id'=>$posts['user_id']]);
    }
}
