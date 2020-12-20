<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['people_id', 'contact_type_id', 'data'];

    public function people(){
        return $this->belongsTo(People::class, 'people_id');
    }
    public function contactType(){
        return $this->belongsTo(ContactTypes::class);
    }
}
