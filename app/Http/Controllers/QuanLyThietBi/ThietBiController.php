<?php

namespace App\Http\Controllers\QuanLyThietBi;

use App\Http\Controllers\Controller;
use App\Models\LoaiThietBi;
use Illuminate\Http\Request;

class ThietBiController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5); // Số lượng bản ghi mỗi trang, mặc định là 5
        $loaiThietBis = LoaiThietBi::paginate($perPage);

        return view('QuanLyThietBi.QuanLyThietBi', compact('loaiThietBis'));
    }
}
