<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BilleteraUsuario extends Model
{
    use SoftDeletes;

    protected $table = 'billetera_usuario';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'saldo',
        'user_id',
    ];

}
