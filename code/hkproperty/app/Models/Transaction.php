<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'package_id', 'transaction_type_id', 'transaction_amount',
        'transaction_date', 'commission', 'facilitated_by', 'customer_id',
        'created_by', 'updated_by'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class);
    }

    public function facilitatedBy(){
        return $this->belongsTo(User::class, 'facilitated_by');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
