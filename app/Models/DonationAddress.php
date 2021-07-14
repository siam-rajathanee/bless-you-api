<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'subdistrict',
        'district',
        'province',
        'zip_code',
        'address_allowed_at',
    ];

    public function donations()
    {
        return $this->belongsTo(Donation::class);
    }
}
