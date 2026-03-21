<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'package',
        'location',
        'booking_date',
        'message',
        'admin_notes',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];
}
