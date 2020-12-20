<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function districts(){
        return $this->hasMany(District::class);
    }

    public function prefers(){
        return $this->hasMany(CustomerPrefer::class);
    }
}
