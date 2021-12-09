<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{ 
   /**
   * @param array $user
   * @return int; 
   */
   function registerUser(array $user);
   
   /**
   * @param string $document_number
   * @return int; 
   */
   function getUserIdByDocumentNumber(string $documentNumber);
   
   /**
   * @param string $document_number
   * @param string $phone_number
   * @return array; 
   */
   function checkUserData(string $document_number,string $phone_number);
   
}