<?php

	namespace App\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;
	use Illuminate\Validation\Rule;

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
		 * @return array<string, mixed>
		 */
		public function rules()
		{
			$id = $this->route('product');

			return [
				'name' => ['required', 'string', 'min:3', 'max:255',
				Rule::unique('products', 'name')->ignore($id) ,'filter:php,laravel,html',],
				'description' => 'required', 'string', 'min:3', 'max:255',
				'category_id' => ['required', 'string', 'exists:categories,id'],
				'store_id' => ['required', 'string', 'exists:stores,id'],
				'image' => ['image'],
				'status' => 'required|in:active,draft,archived',
				'price' => 'required|numeric|min:0',
				'compare_price' => 'nullable|numeric|min:0',
				'tags' => 'nullable|string',

			];
		}

		public function messages()
		{
			return ['name.unique' => 'This name is already exists!',];
		}
	}
