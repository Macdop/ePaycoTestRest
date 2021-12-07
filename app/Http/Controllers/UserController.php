<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementations\UserServiceImplement;
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
            $response = response(
                ['success' => false,
                'cod_error' => 422,
                'message_eror' => $validator->errors()
            ],422);
        }
        else
        {
            $response = response([
                'success' => true,
                'cod_error' => 00,
                'message_error' => 'Sin error',
                ],201);

            $this->userService->registerUser($this->request->all());
        }
        
        return $response;
    }
    // crear soap que guarde los datos en la base de datos

    public function loginUser()
    {
        $validator = $this->validator->validate();
        
        if($validator->fails())
        {
            $response = response(
                ['success' => false,
                'cod_error' => 422,
                'message_eror' => $validator->errors()
            ],422);
        }
        else
        {
            $response = response([
                'success' => true,
                'cod_error' => 00,
                'message_error' => 'Sin error',
                ],201);

            $this->userService->loginUser($this->request->all());
        }
        
        return $response;
    }
}
