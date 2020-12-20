<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTypes extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function Contacts(){
        return $this->hasMany(Contact::class);
    }
}