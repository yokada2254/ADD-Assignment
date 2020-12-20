<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;

    protected $fillable = ['area_id', 'name'];

    public function estates(){
        return $this->hasMany(Estate::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function targets(){
        return $this->morphedByMany(Target::class, 'target');
    }
}
