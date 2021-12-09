<?php

namespace App\Services\Interfaces;

interface BilleteraServiceInterface
{ 
   /**
   * @param int $user
   * @return void; 
   */
   function registerOpeningBalance(int $user);

   /**
   * @param float $value
   * @param int $user
   * @return void; 
   */
   function registerDeposit(float $value,int $user);

}