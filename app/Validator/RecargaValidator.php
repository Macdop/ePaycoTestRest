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
         
      ];
   }
}