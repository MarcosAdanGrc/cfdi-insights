<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['company_id','rfc','name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function invoices(){
        return $this->belongsTo(Invoice::class);
    }
}
