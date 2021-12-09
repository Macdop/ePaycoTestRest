<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementations\UserServiceImplement;
use App\Services\Implementations\BilleteraServiceImplement;
use App\Validator\RecargaValidator;

class BilleteraController extends Controller
{
    /**
    * @var BilleteraServiceImplement
    */
    private $billeteraService;
    
    /**
    * @var Request
    */
    private $request;
    
    /**
    * @var RecargaValidator
    */
    private $recargaValidator;
    
    public function __construct(BilleteraServiceImplement $billeteraService, Request $request, RecargaValidator $recargaValidator)
    {
        $this->billeteraService = $billeteraService;
        $this->request = $request;
        $this->recargaValidator = $recargaValidator;
    }
    
    public function registerDeposit()
    {
        $validator = $this->recargaValidator->validate($this->request->all());
        
        if ($validator->fails())
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => $validator->errors()],422);
            return $response;
        }
        
        $userService = new UserServiceImplement();
        $user = $userService->checkUserData($this->request->document_number,$this->request->phone);
        
        if(!$user)
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => 'Los datos del usuario no coinciden'],422);
            return $response;
        }
        
        $this->billeteraService->registerDeposit($this->request->value,$user->id);
        $response = response(['success' => true,'cod_error' => 00,'message_error' => 'Sin error',],201);
                
        return $response;
    }
}
