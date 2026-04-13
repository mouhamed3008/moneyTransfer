<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $fillable = [
        'montant',
        'type',
        'sender_account_id',
        'receiver_account_id',
        'status',
        'transaction_code',
    ];
}
