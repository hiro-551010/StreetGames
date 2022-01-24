<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CompetitionRequest extends FormRequest
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

    public function sorts($tournaments){
        
        $posts = $this->all();
        // 今日の日付を取得
        $today = Carbon::today();
        // sort
        if (isset($posts['tournaments_sort_date'])){
            //大会開催日での並び替え
            if (empty($posts) || $posts['tournaments_sort_date'] == 'soon') {
                // 開催日が早い順
                $tournaments = $tournaments->orderBy('schedule', 'asc');
                return $tournaments;
            } else {
                // 開催日が遅い順
                $tournaments = $tournaments->orderBy('schedule', 'desc');
                return $tournaments;
            }
        // 大会開催の状態での並び替え
        } elseif (isset($posts['tournaments_sort_status'])){
            // 開催中
            if ($posts['tournaments_sort_status'] == 'held'){
                $tournaments->whereDate('schedule', '<=', $today);
                return $tournaments;
            // 開催前
            } elseif ($posts['tournaments_sort_status'] == 'before'){
                $tournaments->whereDate('schedule', '>=', $today);
                return $tournaments;
            // 大会終了
            } else {
                $tournaments->onlyTrashed();
                return $tournaments;

            }
        } 
    }
}
