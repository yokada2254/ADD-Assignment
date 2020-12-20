<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['status_id', 'created_by', 'updated_by'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function status(){
        return $this->belongsTo(CustomerStatus::class, 'status_id');
    }

    public function people(){
        return $this->morphToMany(People::class, 'related');
    }

    public function prefers(){
        return $this->hasMany(CustomerPrefer::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}