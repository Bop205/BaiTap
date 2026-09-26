<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1000', 'max:10000000'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'image' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sách là bắt buộc',
            'name.string' => 'Tên sách phải là chuỗi',
            'name.min' => 'Tên sách phải có ít nhất 2 kí tự',
            'name.max' => 'Tên sách không được quá 255 kí tự',

            'description.string' => 'Mô tả phải là chuỗi',
            'description.max' => 'Mô tả không được quá 1000 kí tự',

            'price.required' => 'Giá sách là bắt buộc',
            'price.numeric' => 'Giá sách phải là số',
            'price.min' => 'Giá sách phải lớn hơn hoặc bằng 1000',
            'price.max' => 'Giá sách không được quá 10000000',

            'quantity.required' => 'Số lượng là bắt buộc',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng phải lớn hơn 0',
            'quantity.max' => 'Số lượng không được quá 1000',

            'image.string' => 'Hình ảnh phải là chuỗi',
            'image.max' => 'Tên hình ảnh không được quá 255 kí tự',

            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
        ];
    }
}
