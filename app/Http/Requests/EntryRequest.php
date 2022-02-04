<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tournament;
use App\Models\Entry;
use App\Models\Entry_team;
use App\Models\Team;
use DB;

class EntryRequest extends FormRequest
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
        $hold_id = $posts['hold_id'];
        $user_id = \Auth::id();

        // 送信されたtournamentの情報を取得
        $tournament = Tournament::where('hold_id', $hold_id)
            ->join('titles', 'titles.title_id', 'tournaments.title_id')
            ->first();
        
        $team = Team::where('reader_id', $user_id)->first();
        
        // そのトーナメントがチーム戦かどうか
        if (isset($tournament['team_number'])){
            // 応募しているuserがチームリーダーか
            if (isset($team)){
                // チーム戦だった場合 
                $entry_team = new Entry_team;
                $entry_team->create([
                    'team_id' => $user_id,
                    'hold_id' => $tournament['hold_id'],
                    'join' => 1
                ]);
            } else {
                // 募集してからチームを募集する場合はここに処理を書く？
                // その場合は$teamのeloquentを変えるかも
                dd('チームリーダーが応募してください');
            }

        } else {
            // 個人戦だった場合
            DB::transaction(function () use($posts) {
                $entry = new Entry;
                $entry->create([
                   'user_id' => $posts['user_id'],
                   'hold_id' => $posts['hold_id'],
                   'join' => '1'
                ]);
            });
        }
    }
}