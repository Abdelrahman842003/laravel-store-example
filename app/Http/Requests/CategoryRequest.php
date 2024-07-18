<?php

	namespace App\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;
	use Illuminate\Validation\Rule;

	class CategoryRequest extends FormRequest
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
			$id = $this->route('category');

			return ['name' => ['required', 'string', 'min:3', 'max:255', // "unique:categories,name,$id",
				Rule::unique('categories', 'name')->ignore($id), /*function($attribute, $value, $fails) {
					if (strtolower($value) == 'laravel') {
						$fails('This name is forbidden!');
					}
				},*/ 'filter:php,laravel,html',//new Filter(['php', 'laravel', 'html']),
			], 'parent_id' => ['nullable', 'int', 'exists:categories,id'], 'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100',], 'status' => 'required|in:active,archived',];
		}

		public function messages()
		{
			return ['name.unique' => 'This name is already exists!',];
		}
	}
