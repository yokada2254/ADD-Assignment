<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPreferAreaDistrict extends Model
{
    use HasFactory;
    protected $fillable = ['customer_prefer_id', 'area_id', 'district_id'];

    public function prefer(){
        return $this->belongsTo(CustomerPrefer::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function estates(){
        return $this->belongsToMany(Estate::class, 'customer_prefer_estate');
    }
}
