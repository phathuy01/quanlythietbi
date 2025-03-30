<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanBo extends Model
{
    protected $table = 'canbo';
    protected $primaryKey = 'id_cb';
    public $timestamps = false;

    protected $fillable = ['hoten', 'sdt', 'email', 'diachi', 'id_dv'];

    public function donvi()
    {
        return $this->belongsTo(DonVi::class, 'id_dv');
    }
}
