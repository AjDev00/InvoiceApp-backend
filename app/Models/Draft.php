<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;

    protected $casts = [
        'bill_to_invoice_date' => 'datetime:d-m-Y', // or any standard format for internal use
    ];


    //define a relationship with the DraftItem model.
    public function draftItem(){
        return $this->hasMany(DraftItem::class);
    }
}
