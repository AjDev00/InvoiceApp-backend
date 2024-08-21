<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    //define a relationship with the ItemList model.
    public function itemList(){
        return $this->hasMany(ItemList::class);
    }
}
