<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'donate',
        'amount',
        'proof_of_transfer',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function address()
    {
        return $this->hasOne(DonationAddress::class);
    }
}
