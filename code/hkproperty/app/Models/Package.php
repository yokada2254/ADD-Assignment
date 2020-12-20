<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['status_id', 'created_by', 'updated_by'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function properties(){
        return $this->belongsToMany(Property::class);
    }
    public function owners(){
        return $this->morphToMany(People::class, 'related');
    }
    public function offers(){
        return $this->hasMany(PackageOffer::class);
    }
    public function status(){
        return $this->belongsTo(PackageStatus::class);
    }
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}