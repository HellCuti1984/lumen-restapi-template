<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'type_id', 'serial', 'remark'
    ];  
    protected $hidden = [];

    public function types(){
        return $this->hasOne(TypeEquipment::class, 'id', 'type_id');
    }
}
