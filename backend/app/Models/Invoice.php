<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['company_id','supplier_id','uuid','issued_at','subtotal','tax','total'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function items(){
        return $this->hasMany(InvoiceItem::class);
    }
}
