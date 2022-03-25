<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEquipment extends Model
{
    protected $fillable = [
        'name', 'mask'
    ];  
    protected $hidden = [];

    public function equipments(){
        return $this->belongsTo(Equipment::class);
    }
}
