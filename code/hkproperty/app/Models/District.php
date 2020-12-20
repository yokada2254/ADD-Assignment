<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['area_id', 'name'];

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function estates(){
        return $this->hasMany(Estate::class);
    }

    public function prefers(){
        return $this->hasMany(CustomerPrefer::class);
    }
}