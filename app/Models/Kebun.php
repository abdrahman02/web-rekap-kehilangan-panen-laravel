<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rekap()
    {
        return $this->hasMany(Rekap::class, 'kebun_id', 'id');
    }
}
