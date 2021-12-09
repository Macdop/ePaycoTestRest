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

   /**
   * @param int $user
   * @return void; 
   */
  function checkWallet(int $user);

  /**
   * @param float $value
   * @param int $user_id
   * @param string $recipient_document_number
   * @return void; 
   */
  function TransferValue(float $value,int $user_id,string $recipient_user_id);

}