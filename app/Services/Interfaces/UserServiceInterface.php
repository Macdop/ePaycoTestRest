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
   
   
}