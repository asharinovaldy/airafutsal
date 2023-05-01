<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['prefix', 'field_id', 'user_id', 'boots_id', 'balls_id', 'name', 'booking_time', 'duration', 'booking_date', ''];
}
