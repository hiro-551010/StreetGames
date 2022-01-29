<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Team;
use App\Models\Team_content;
use DB;

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

        // teamテーブルにデータを挿入
        DB::transaction(function () use($posts) {
            $team = new Team;
            $teams = $team->create([
                'title_id'=>$posts['title_id'],
                'team_name'=>$posts['team_name'],
                'reader_id'=>$posts['user_id']
            ]);

            // team_contentsテーブルにデータを挿入
            $team_content = new Team_content;
            $team_content->create([
                'team_id'=>$teams->id,
                'user_id'=>$posts['user_id']
            ]);
        });
        
    }
}
