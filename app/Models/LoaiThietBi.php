<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiThietBi extends Model
{
    protected $table = 'loaithietbi';
    protected $primaryKey = 'id_ltb';

    protected $fillable = [
        'ten_ltb',
        'mota'
    ];
}
