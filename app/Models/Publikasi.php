<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $fillable = [
        'user_id',
        'upt_id',
        'tanggal',
        'kegiatan',
        'link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upt()
    {
        return $this->belongsTo(Upt::class);
    }
}
