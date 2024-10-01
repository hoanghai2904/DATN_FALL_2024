<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is optional but must be valid if provided
            'url' => 'required|url', // URL is required and must be valid
            'status' => 'required|in:0,1', // Status must be either 0 or 1
        ];
    }
    public function messages()
    {
        return [
            'banner.image' => 'Banner phải là một hình ảnh hợp lệ.',
            'url.required' => 'URL là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là 0 (không hoạt động) hoặc 1 (hoạt động).',
        ];
    }
}
