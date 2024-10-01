<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'thumbnail' => 'required|string',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'product_type' => 'required|in:Sale,Hot Trend',
            'status' => 'required|boolean',
            // 'variants' => 'nullable|array', // Danh sách các biến thể
            // 'variants.*.product_size_id' => 'required|integer',
            // 'variants.*.product_color_id' => 'required|integer',
            // 'variants.*.qty' => 'required|integer|min:0',
            // 'variants.*.image' => 'nullable|string'
        ];
    }
    public function messages()
    {
        return [
            'category_id.required' => 'Danh mục sản phẩm không được để trống.',
            'brand_id.required' => 'Thương hiệu không được để trống.',
            'thumbnail.required' => 'Thumbnail không được để trống.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'slug.required' => 'Slug không được để trống.',
            'slug.unique' => 'Slug đã tồn tại.',
            'sku.required' => 'SKU không được để trống.',
            'sku.unique' => 'SKU đã tồn tại.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'price.numeric' => 'Giá phải là số.',
            'product_type.required' => 'Loại sản phẩm không được để trống.',
            'status.required' => 'Trạng thái không được để trống.',
            // 'variants.*.product_size_id.required' => 'ID kích thước là bắt buộc cho mỗi biến thể.',
            // 'variants.*.product_color_id.required' => 'ID màu sắc là bắt buộc cho mỗi biến thể.',
            // 'variants.*.qty.required' => 'Số lượng là bắt buộc cho mỗi biến thể.',
        ];
    }
}
