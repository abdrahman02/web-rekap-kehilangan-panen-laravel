<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'kebun_id', 'id');
    }
}
