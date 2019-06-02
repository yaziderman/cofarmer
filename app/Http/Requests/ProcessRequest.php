<?php

namespace App\Http\Requests;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AreaCovered;

class ProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return booluse Auth;
     */
    public function authorize()
    {
           // an extra layer of security,
        //  you can check for user role and permission to check if 
        //      user can do this particular task here,
        //  you can also skip it by return true;
        if(Auth::guard('api')->check())
        {
           // I'm using Entrust for user role management
           $user = Auth::guard('api')->user();
           switch($this->getMethod())
           {
               case 'post':
               case 'POST':
                  return $user->hasPermission('create-process');
               case 'put':
               case 'PUT':
                  return $user->hasPermission('update-process');
               case 'DELETE':
               case 'delete':
                  return $user->hasPermission('delete-process');
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
            case 'put':
            case 'PUT':
                return [
                    'tractor_id' => 'required',
                    'field_id' => 'required',
                    'planned_date' => 'required',
                    'area' => ['required','numeric', new AreaCovered($this->field_id)],
                ];
            case 'delete':
            case 'DELETE':
               return [
                   'process_id' => 'required|exists:processes,id'
               ];
          }
          return [];
    }
}
