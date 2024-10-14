<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'body' => 'required',
        ];
    }
    public function messages(){
        return[
            'title.required'=>'Tiêu đề không được bỏ trống',
            'user_id.required'=>'Tác giả không được bỏ trống',
            'status.required'=>'Trạng thái không được bỏ trống',
            'category_id.required'=>'Danh mục không được bỏ trống',
            'body.required'=>'Nội dung không được bỏ trống',
            
        ];
    }
}
