<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_date',
        'reservation_time',
        'number_of_guests',
        'table_number',
        'status',
        'notes',
        'guest_gender',
        'guest_first_name',
        'guest_last_name',
        'guest_email',
        'guest_phone_number',
        'agreed_dietary_policy',
        'receive_promotions',
        'personalized_recommendations',
        'agreed_terms',
        'agreed_cancellation_policy',
        'payment_method',
        'voucher_code',
        'hold_amount',
        'transaction_id',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
