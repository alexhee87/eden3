<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Role;

class UserRequest extends FormRequest
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
        // $user = $this->route('user');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                $validate = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'sometimes|required|max:255|unique:users|regex:/^[a-zA-Z0-9_\.\-]*$/',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed'
                ];

                if(config('config.enable_tnc'))
                    $validate['tnc'] = 'accepted';

                return $validate;
            }
            case 'PUT':
            case 'PATCH':
            {
                $validate = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'sometimes|required|max:255|regex:/^[a-zA-Z0-9_\.\-]*$/|unique:users,username,'.$user->id,
                    'email' => 'required|email|max:255|unique:users,email'.$user->id,
                    'password' => 'required|min:6|confirmed'
                ];

                if(config('config.enable_tnc'))
                    $validate['tnc'] = 'accepted';

                return $validate;
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'tnc' => 'terms and conditions'
        ];
    }
}
