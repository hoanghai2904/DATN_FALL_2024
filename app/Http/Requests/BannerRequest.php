<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
            // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'banner' => 'required|image',
            // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Validate image with max size 5MB
            'url' => 'required|url', // Validate URL
            'status' => 'required|in:0,1', // Ensure status is 0 or 1
        ];
        
    }
    public function messages()
    {
        return [
            'banner.required' => 'Ảnh banner là bắt buộc.',
            'banner.image' => 'Tệp phải là một hình ảnh hợp lệ.',
            'url.required' => 'URL là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là 0 (không hoạt động) hoặc 1 (hoạt động).',
        ];
    }
}
