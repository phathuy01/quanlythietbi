<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    protected $table = 'quyen';
    protected $primaryKey = 'id_q';
    public $timestamps = false;

    protected $fillable = ['ten_q', 'mota'];
}
