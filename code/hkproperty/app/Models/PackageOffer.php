<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOffer extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'transaction_type_id', 'price'];

    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function transactionType(){
        return $this->belongsTo(TransactionType::class);
    }
}