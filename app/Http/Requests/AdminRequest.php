<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Topic;
use App\Models\Content;
use App\Models\Event;
use DB;

class AdminRequest extends FormRequest
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
            //見出しの文字制限をつける
        ];
    }

    public function creates_topics(){
        $heading = $this->heading;
        // $content = $this->content; とするとtokenまでとれてしまう
        $content = $this->contents;
        DB::transaction(function () use($heading, $content) {
            $topic = new Topic;
            $topic->create(['heading'=>$heading, 'content'=>$content]);
        });
    }

    public function creates_events(){
        $heading = $this->heading;
        $content = $this->contents;
        DB::transaction(function () use($heading, $content) {
            $event = new Event;
            $event->create(['heading'=>$heading, 'content'=>$content]);
        });
    }


}
