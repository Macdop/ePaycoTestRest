<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementations\UserServiceImplement;
use App\Services\Implementations\BilleteraServiceImplement;
use App\Validator\UserValidator;

class UserController extends Controller
{
    /**
    * @var UserServiceImplement
    */
    private $userService;
    
    /**
    * @var Request
    */
    private $request;
    
    /**
    * @var UserValidator
    */
    private $validator;
    
    public function __construct(UserServiceImplement $userService, Request $request, UserValidator $userValidator)
    {
        $this->userService = $userService;
        $this->request = $request;
        $this->validator = $userValidator;
    }
    
    public function registerUser()
    {
                
        $validator = $this->validator->validate();
        
        if($validator->fails())
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => $validator->errors()],422);
        }
        else
        {
            $this->userService->registerUser($this->request->all());

            $user_id = $this->request->document_number;

            $billetera = new BilleteraServiceImplement();
            $billetera->registerOpeningBalance($this->userService->getUserIdByDocumentNumber($user_id));

            $response = response(['success' => true,'cod_error' => 00,'message_error' => 'Sin error',],201);
        }
        
        return $response;
    }

}
