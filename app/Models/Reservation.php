<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


     public $timestamps = false;
     protected $fillable = [
        'customer_name',
        'contact_number',
        'start_date',
        'end_date',
        'room_type',
        'room_capacity',
        'payment_type',
        'total_bill'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_bill' => 'decimal:2'
    ];
}