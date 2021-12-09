<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\TransacctionTokenServiceInterface;
use App\Models\TransacctionToken;
use Illuminate\Support\Facades\Hash;

class TransacctionTokenServiceImplement implements TransacctionTokenServiceInterface
{
   private $model;

   public function __construct()
   {
      $this->model = new TransacctionToken();
   }
      
   /**
    * Register a Transaction Token
    */
   function setTransacctionToken(int $user,string $recipient_document_number,float $value)
   {
      $this->model->user_id = $user;
      $this->model->recipient_document_number = $recipient_document_number;
      $this->model->value = $value;
      $this->model->token = $token = rand(100000, 999999);
      $this->model->save();
      return array('token'=>$token,'transacction'=>$this->model->id);
   }

   /**
    * Get Transaction Token
    */
   function getTransacctionToken(int $token, int $transacction_id)
   {
      $transactionToken = TransacctionToken::where([['token', $token],['id',$transacction_id]])->first();
      return $transactionToken;
   }

   /**
    * Delete Transaction Token
    */
   function deleteTransacctionToken(int $transacction_id)
   {
      $transactionToken = TransacctionToken::where('id',$transacction_id)->first();
      $transactionToken->delete();
   }

}