<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPrefer extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'transaction_type_id', 'fm', 'to', 'room'];

    public function customer(){
        return $this->beblongsTo(Customer::class);
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class);
    }

    public function areaDistricts(){
        return $this->hasMany(CustomerPreferAreaDistrict::class);
    }

    public function estates(){
        return $this->belongsToMany(Estate::class);
    }
}
