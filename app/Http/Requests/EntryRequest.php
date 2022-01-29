<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tournament;
use App\Models\Entry;
use App\Models\Entry_team;
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

        // 送信されたtournamentの情報を取得
        $tournament = Tournament::where('hold_id', $hold_id)
            ->join('titles', 'titles.title_id', 'tournaments.title_id')
            ->get();
        
        // そのトーナメントがチーム戦かどうか
        if (isset($tournament[0]['team_number'])){
            // チーム戦だった場合
            // $entry = new Entry;
            // $entry->create([
            // ]);
            dd('未実装');
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