<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class checkWalletValidator
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
      ];
   }
   
   public function messages()
   {
      return [
         
      ];
   }
}