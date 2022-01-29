<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Team;

class TeamCreateRequest extends FormRequest
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

    public function creates(){
        $posts = $this->all();

        $team = new Team;
        $team->create([
            'title_id'=>$posts['title_id'],
            'team_name'=>$posts['team_name'],
            'reader_id'=>$posts['user_id']
        ]);
    }
}
