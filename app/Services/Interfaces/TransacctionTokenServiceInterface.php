<?php

namespace App\Services\Interfaces;

interface TransacctionTokenServiceInterface
{ 
   /**
   * @param int $user
   * @param string $recipient_document_number
   * @param float $value
   * @return array; 
   */
   function setTransacctionToken(int $user,string $recipient_document_number,float $value);
   
   /**
   * @param int $token
   * @param int $transacction_id
   * @return array; 
   */
   function getTransacctionToken(int $token,int $transacction_id);
   
   /** 
   * @param int $transacction_id
   * @return void;
   */
   function deleteTransacctionToken(int $transacction_id);
}