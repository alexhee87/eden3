<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'to_user_id' => 'required',
            'subject' => 'required',
            'attachments' => 'mimes:'.config('config.allowed_upload_file')
            ];
    }

    public function attributes()
    {
        return[
            'to_user_id' => 'receiver',
        ];

    }
}