<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
//            'old_price' => 'required|numeric',
//            'quantity' => 'required|numeric',
            'image' => 'image|max:2048|mimes:png,gif,jpeg,jpg',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
//            'old_price.required' => 'Giá nhập vào không được để trống',
//            'price.numeric' => 'Giá nhập vào phải là số',
//            'quantity.required' => 'Số lượng không được để trống',
//            'quantity.numeric' => 'Số lượng phải là số',
            'image.image' => 'Phải là hình ảnh',
            'image.max' => 'Ảnh không được quá 2MB',
            'image.mimes' => 'Định dạng ảnh không đúng.(Định dạng đúng: jpeg,png,gif,jpg',
        ];
    }
}
