<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementations\UserServiceImplement;
use App\Services\Implementations\BilleteraServiceImplement;
use App\Services\Implementations\TransacctionTokenServiceImplement;
use App\Validator\RecargaValidator;
use App\Validator\CheckWalletValidator;
use Illuminate\Support\Facades\Mail;
use App\Mail\tokenPago;

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
    
    public function sendDeposit()
    {   
        
        $userService = new UserServiceImplement();
        $user = $userService->checkUserData($this->request->document_number,$this->request->phone);
        
        if(!$user)
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => 'Los datos del usuario no coinciden'],422);
            return $response;
        }
        
        $recipient = $userService->getUserIdByDocumentNumber($this->request->recipient_document_number);
        
        if(!$recipient)
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => 'No existe el destinatario'],422);
            return $response;
        }
        
        $walletBalance = $this->billeteraService->checkWallet($user->id);
        
        if($walletBalance < $this->request->value)
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => 'No tiene saldo suficiente'],422);
            return $response;
        }

        $trassactionToken = new TransacctionTokenServiceImplement();

        $recipient_document_number = $this->request->recipient_document_number;
        $value = $this->request->value;
        $transacction = $trassactionToken->setTransacctionToken($user->id,$recipient_document_number,$value);
        $email = $user->email;
        $name = $user->firstname;
        $url = url('/');
        $message_token = "Hello ".$name.',This is your token:'.$transacction['token'];

        /*
        $recipients = [$email];
        Mail::raw($message_token, function ($message) use ($recipients) {
            $message->subject('Token Confirmation');
            $message->to($recipients);
        });
        */
        
        $response = response(['success' => true,'cod_error' => 00,'message_error' => 'Se ha enviado un correo para confirmar el pago','transacction_number'=>$transacction['transacction']],200);
        
        return $response;
    }

    public function DepositConfirm()
    {
        $trassactionToken = new TransacctionTokenServiceImplement();       
        $transacction = $trassactionToken->getTransacctionToken($this->request->token,$this->request->transacction_number);

        if(!$transacction)
        {
            $response = response(['success' => false,'cod_error' => 422,'message_eror' => 'El token no existe'],422);
            return $response;
        }

        $userService = new UserServiceImplement();
        $recipient = $userService->getUserIdByDocumentNumber($transacction->recipient_document_number);
        
        $this->billeteraService->TransferValue($transacction->value,$transacction->user_id,$recipient);
        $trassactionToken->deleteTransacctionToken($transacction->id);
        $response = response(['success' => true,'cod_error' => 00,'message_error' => 'Sin error',],200);
        
        return $response;
    }
    
}
