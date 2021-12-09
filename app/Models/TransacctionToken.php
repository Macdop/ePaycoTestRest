<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransacctionToken extends Model
{
    protected $table = 'transacction_token';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'token',
        'user_id',
        'recipient_document_number',
        'value',
    ];
}
