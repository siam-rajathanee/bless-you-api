<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
