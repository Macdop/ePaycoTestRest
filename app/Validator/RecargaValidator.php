<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecargaValidator
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
         'document_number' => 'required',
         'phone' => 'required',
         'value' => 'required|numeric',
      ];
   }
   
   public function messages()
   {
      return [
         'document_number.required' => 'O campo documento é obrigatório',
         'phone.required' => 'O campo telefone é obrigatório',
         'value.required' => 'O campo valor é obrigatório',
         'value.numeric' => 'O campo valor deve ser numérico',
      ];
   }
}