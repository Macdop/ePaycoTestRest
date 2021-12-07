<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{ 
   /**
   * @param array $user
   * @return boolean; 
   */
   function registerUser(array $user);

}