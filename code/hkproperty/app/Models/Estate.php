<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $fillable = ['estate_type_id', 'district_id', 'name', 'address'];

    public function properties(){
        return $this->hasMany(Property::class);
    }

    public function estateType(){
        return $this->belongsTo(EstateType::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function prefers(){
        return $this->hasMany(CustomerPreferAreaDistrict::class, 'customer_prefer_estate');
    }
}