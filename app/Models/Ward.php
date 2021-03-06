<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';

    protected $fillable = [
        'ward_id',
        'name',
        'type',
        'location',
        'district_id'
    ];
}
