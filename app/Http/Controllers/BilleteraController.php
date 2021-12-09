<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementations\UserServiceImplement;
use App\Services\Implementations\BilleteraServiceImplement;
use App\Validator\RecargaValidator;
use App\Validator\CheckWalletValidator;

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
    
    /**
    * @var CheckWalletValidator
    */
    private $checkWalletValidator;
    
    public function __construct(BilleteraServiceImplement $billeteraService, Request $request, RecargaValidator $recargaValidator,CheckWalletValidator $checkWalletValidator)
    {
        $this->billeteraService = $billeteraService;
        $this->request = $request;
        $this->recargaValidator = $recargaValidator;
        $this->checkWalletValidator = $checkWalletValidator;
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
    
    public function checkWallet()
    {
        $validator = $this->checkWalletValidator->validate($this->request->all());
        
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
        
        $walletBalance = $this->billeteraService->checkWallet($user->id);
        
        $response = response(['success' => true,'balance' => $walletBalance,'cod_error' => 00,'message_error' => 'Sin error',],200);
        
        return $response;
    }
    
}
