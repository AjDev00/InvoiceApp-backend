<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;

    //define a relationship with the DraftItem model.
    public function draftItem(){
        return $this->hasMany(DraftItem::class);
    }
}
