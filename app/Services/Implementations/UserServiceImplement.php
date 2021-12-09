<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServiceImplement implements UserServiceInterface
{
   private $model;

   public function __construct()
   {
      $this->model = new User();
   }
      
   /**
    * Register a new user
    */
   function registerUser(array $user)
   {
      $this->model->create($user);
   }

   /**
    * Get user id by document number
    */
   function getUserIdByDocumentNumber($document_number)
   {
      $user = $this->model->where('document_number', $document_number)->first();
      return $user->id;
   }

   /**
    * Check user data by document number and phone number
    */
   function checkUserData($document_number, $phone_number)
   {
      $user = $this->model->where('document_number', $document_number)
         ->where('phone', $phone_number)
         ->first();
      return $user;
   }

}