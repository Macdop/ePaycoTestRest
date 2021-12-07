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
         
      ];
   }
}