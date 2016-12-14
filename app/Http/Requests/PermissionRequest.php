<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Permission;

class PermissionRequest extends FormRequest
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
        $permission = $this->route('permission');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|unique:permissions,name',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:permissions,name,'.$permission->id
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'name' => trans('messages.permission').' '.trans('messages.name'),
        ];
    }
}
