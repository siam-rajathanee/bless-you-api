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
        'status',
    ];

    public function getFullnameAttribute()
    {
        return implode(' ', [$this->firstname, $this->lastname]);
    }

    public function getProofOfTransferAttribute()
    {
        return asset(\Storage::url($this->attributes['proof_of_transfer']));
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function address()
    {
        return $this->hasOne(DonationAddress::class);
    }

    public function blessingCard()
    {
        return $this->hasOne(BlessingCard::class);
    }
}
