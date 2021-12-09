<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidator
{
   /**
   * @var Request
   */
   
   private $request;
   
   public function __construct(Request $request)
   {
      $this->request = $request;
   }
   
   public function validate()
   {
      return Validator::make($this->request->all(),$this->rules(),$this->messages());
   }
   
   public function rules()
   {
      return [
         'firstname' => 'required',
         'lastname' => 'required',
         'document_number' => 'required|unique:users,document_number,'.$this->request->id,
         'email' => 'required|email|unique:users,email,'.$this->request->id,
         'phone' => 'required',
      ];
   }
   
   public function messages()
   {
      return [
         'firstname.required' => 'El campo nombre es obligatorio',
         'lastname.required' => 'El campo apellido es obligatorio',
         'document_number.required' => 'El campo documento es obligatorio',
         'document_number.unique' => 'El documento ya existe',
         'email.required' => 'El campo email es obligatorio',
         'email.email' => 'El email no es valido',
         'email.unique' => 'El email ya existe',
         'phone.required' => 'El campo telefono es obligatorio',
      ];
   }
}