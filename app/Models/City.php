<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }    

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
