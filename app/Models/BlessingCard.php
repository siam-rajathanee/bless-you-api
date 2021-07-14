<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlessingCard extends Model
{
    use HasFactory;

    protected $fillable = ['card'];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
