<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
