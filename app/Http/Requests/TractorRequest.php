<?php

namespace App\Http\Requests;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class TractorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if(Auth::guard('api')->check())
        {
           $user = Auth::guard('api')->user();
           switch($this->getMethod())
           {
               case 'post':
               case 'POST':
                  return $user->hasPermission('create-tractor');
               case 'put':
               case 'PUT':
                  return $user->hasPermission('update-tractor');
               case 'DELETE':
               case 'delete':
                  return $user->hasPermission('delete-tractor');
           }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            case 'post':
            case 'POST':
                return [
                    'name' => 'required|unique:tractors,name',
                ];

            case 'put':
            case 'PUT':
                return [
                    'id' => 'required|exists:tractors,id',
                    // 'name'        => [
                    //     'required',Rule::unique('tractors')->ignore(request(id))
                    //         ]
                ];
            case 'delete':
            case 'DELETE':
               return [
                   'tractor_id' => 'required|exists:tractors,id'
               ];
          }
          return [];
    }
}
