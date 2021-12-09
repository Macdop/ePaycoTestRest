<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\BilleteraServiceInterface;
use App\Models\BilleteraUsuario;

class BilleteraServiceImplement implements BilleteraServiceInterface
{
   private $model;
   
   public function __construct()
   {
      $this->model = new BilleteraUsuario();
   }
   
   /**
   * Register opening balance
   */
   function registerOpeningBalance(int $user)
   {
      $this->model->user_id = $user;
      $this->model->saldo = 0;
      $this->model->save();
   }
   
   /**
   * Register a deposit
   */
   function registerDeposit(float $value,int $user)
   {
      $billetera = $this->model->where('user_id', $user)->first();
      $billetera->saldo = $billetera->saldo + $value;
      $billetera->save();
   }
   
   /**
   * Check Wallet
   */
   function checkWallet(int $user)
   {
      $billetera = $this->model->where('user_id', $user)->first();
      return $billetera->saldo;
   }
   
   
   /**
   * Transfer Value
   */
   function TransferValue(float $value,int $user_id,string $recipient_user_id)
   {
      $billetera = $this->model->where('user_id', $user_id)->first();
      $billetera->saldo = $billetera->saldo - $value;
      $billetera->save();
      
      $billetera_recipient = $this->model->where('user_id', $recipient_user_id)->first();
      $billetera_recipient->saldo = $billetera_recipient->saldo + $value;
      $billetera_recipient->save();
   }
   
}