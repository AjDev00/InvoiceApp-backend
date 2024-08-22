<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftItem extends Model
{
    use HasFactory;

    protected $guarded = [ ];


    //define a reverse relationship with the Draft model.
    public function invoice(){
        return $this->belongsTo(Draft::class);
    }
}
