<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DonVi extends Model
{
    use HasFactory;

    protected $table = 'donvi';

    protected $primaryKey = 'id_dv';

    public $incrementing = false;


    protected $fillable = [
        'id_dv', 'ten_dv', 'ten_viettat', 'id_p', 'trichxuat', 'sdt', 'email', 'mota'
    ];
}
