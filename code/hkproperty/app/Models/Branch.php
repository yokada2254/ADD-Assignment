<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'manager', 'name'];

    public function managedBy(){
        return $this->hasOne(User::class);
    }
    
    public function staff(){
        return $this->hasMany(User::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
