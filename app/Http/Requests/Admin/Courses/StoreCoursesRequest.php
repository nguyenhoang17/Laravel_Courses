<?php

namespace App\Http\Requests\Admin\Courses;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreCoursesRequest extends FormRequest
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
            'name'   => ['required','string','max: 255', 'unique:courses'],
            'category_id' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png,gif'],
            'type' => ['required'],
            'start_time' => 'required|after:' . Carbon::now(),
            'end_time' => ['required', 'after:start_time'],
            'price' => ['required', 'numeric'],
            'files' => ['required'],
            'files.*' => ['mimes:pdf'],
            'tags' => ['required'],
            'video' => ['mimetypes:video/avi,video/mpeg,video/quicktime']
        ];
    }
}
