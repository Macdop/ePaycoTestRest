<?php

namespace App\Services\Interfaces;

interface BilleteraServiceInterface
{ 
   /**
   * @param int $user
   * @return void; 
   */
   function registerOpeningBalance(int $user);

}