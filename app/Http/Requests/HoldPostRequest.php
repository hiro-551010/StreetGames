<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
use App\Models\Tournament;
use App\Models\Tournament_content;

class HoldPostRequest extends FormRequest
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

    // トーナメントのinsert処理を行う関数
    public function creates(){
        $posts = $this->all();
        $schedule = $posts['year']. '/'. $posts['month']. '/'. $posts['day'];
        
        // prizeのname属性に値が入っていなかった場合、「なし」を返す
        if (empty($posts['prize'])) {
            $posts['prize'] = "なし";
        }

        DB::transaction(function () use($posts, $schedule) {
            // user_idをインサートしてhold_idをとってくる
            $host = DB::table('hosts')->insertGetId(['user_id' => $posts['user_id']], 'hold_id');
            $title_id = Tournament::insert([
                'title_id' => $posts['title_id'],
                'hold_id' => $host,
                'host_name' => $posts['host_name'],
                'explanation' => $posts['explanation'],
                'prize' => $posts['prize']
            ]);
            $tournaments_content = Tournament_content::insert([
                'hold_id' => $host,
                'people' => $posts['people'],
                'rule' => $posts['rule'],
                'schedule' => $schedule
            ]);
        });
    }
}
