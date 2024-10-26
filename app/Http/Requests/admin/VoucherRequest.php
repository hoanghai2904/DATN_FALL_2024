<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
        $rules = [
            'code' => 'required',
            'name' => 'required',
            'discount_type' => 'required',
            'status' => 'required',
            'discount' => 'required|numeric|min:1',
            'max_uses' => 'required|numeric|min:1',
            'qty' => 'required|numeric|min:1',
            'start' => 'required|date|after_or_equal:today',
            'end' => 'required|date|after_or_equal:start'
        ];    
        if ($this->input('discount_type') == '0') {
            $rules['discount'] = 'required|numeric|min:1|max:100'; 
        }
    
        return $rules;
    }
    
    public function messages(){
        return[
            'code.required'=>'Mã giảm giá không được bỏ trống',
            'name.required'=>'Tên mã giảm giá không được bỏ trống',
            'discount_type.required'=>'Vui lòng chọn loại giảm giá',
            'status.required'=>'Vui lòng chọn trạng thái',
            'discount.required'=>'Giá không được để trống',
            'discount.numeric'=>'Giá phải là số',
            'discount.max'=>'giá trị nhỏ hơn 100%',
            'discount.min'=>'Giá phải lớn hơn 1',
            'max_uses.required'=>'Giá không được để trống',
            'max_uses.numeric'=>'Giá phải là số',
            'max_uses.min'=>'Giá phải lớn hơn 1',
            'qty.required'=>'Số lượng không được để trống',
            'qty.numeric'=>'Số lượng phải là số',
            'qty.min'=>'Số lượng phải lớn hơn 1',
            'start.required'=>'Ngày bắt đầu không được để trống',
            'start.date'=>'Giữ liệu phải là thời gian',
            'start.after_or_equal'=>'Ngày bắt đầu phải lớn hơn hoặc bằng hiện tại',
            'end.required'=>'Ngày kết thúc không được để trống',
            'end.date'=>'Giữ liệu phải là thời gian',
            'end.after_or_equal'=>'Ngày kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu',
        ];
    }
}
