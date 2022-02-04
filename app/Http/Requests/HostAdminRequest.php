<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HostAdminRequest extends FormRequest
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

    public function creates($hold_id, $id){
        $posts = $this->all();
        dd($posts, $hold_id, $id);
    }
}
