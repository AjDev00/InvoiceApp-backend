<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemList extends Model
{
    use HasFactory;

    protected $guarded = [ ];


    //define an inverse relationship with the Invoice model.
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
