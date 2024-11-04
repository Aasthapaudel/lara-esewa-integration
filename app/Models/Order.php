<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'name',
        'amount',
        'email'
    ];
    const PAYMENT_COMPLETED = 1;
    const PAYMENT_PENDING = 0;
    }
