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

}