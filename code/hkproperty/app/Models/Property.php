<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model{
    use HasFactory;

    protected $fillable = [
        'room', 'store_room', 'washroom', 'open_kitchen', 'gross_size', 
        'roof_size', 'estate_id', 'block', 'floor', 'flat', 
        'created_by', 'updated_by'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function estate(){
        return $this->belongsTo(Estate::class);
    }

    public function packages(){
        return $this->hasMany(Property::class);
    }

    public function owners(){
        return $this->morphToMany(People::class, 'related');
    }
}