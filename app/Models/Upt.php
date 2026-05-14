<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upt extends Model
{
    protected $fillable=[
        'nama',
        'kode'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function publikasis()
    {
        return $this->hasMany(Publikasi::class);
    }

    
}