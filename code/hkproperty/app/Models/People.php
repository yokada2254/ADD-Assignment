<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'hkid', 'created_by', 'updated_by'];
    protected $hidden = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function contacts(){
        return $this->hasMany(Contact::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function packages(){
        return $this->morphedByMany(Packages::class, 'related');
    }

    public function properties(){
        return $this->morphedByMany(Property::class, 'related');
    }

    public function customers(){
        return $this->morphedByMany(Customers::class, 'related');
    }
}