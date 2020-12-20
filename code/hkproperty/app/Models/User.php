<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'branch_id',
        'license'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function manage(){
        return $this->belongsTo(Branch::class, 'manager_id');
    }
    public function people(){
        return $this->morphTo(People::class, 'related');
    }
    public function createdPackages(){
        return $this->hasMany(Package::class, 'created_by');
    }
    public function updatedPackages(){
        return $this->hasMany(Package::class, 'updated_by');
    }
    public function createdTransactions(){
        return $this->hasMany(Transaciont::class, 'created_by');
    }
    public function updatedTransactions(){
        return $this->hasMany(Transaciont::class, 'updated_by');
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function permitted($privilege){
        if($this->role->privileges->pluck('name')->contains($privilege)){
            return true;
        }
        abort(403);
    }
}