<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagarValidator
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
         'transacction_number' => 'required|numeric',
         'token' => 'required|string',
      ];
   }
   
   public function messages()
   {
      return [
         'transacction_number.required' => 'El número de transacción es requerido',
         'transacction_number.numeric' => 'El número de transacción debe ser un número',
         'token.required' => 'El token es requerido',
         'token.string' => 'El token debe ser una cadena de caracteres',
      ];
   }
}