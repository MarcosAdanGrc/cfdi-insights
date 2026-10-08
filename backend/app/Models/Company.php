<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    public function  users()
    {
        return $this->hasMany(User::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function suppliers(){
        return $this->hasMany(Supplier::class);
    }
}
