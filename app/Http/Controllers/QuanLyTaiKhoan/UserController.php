<?php

namespace App\Http\Controllers\QuanLyTaiKhoan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CanBo;
use App\Models\Quyen;
use App\Models\DonVi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        // Lấy thông tin sort từ request (mặc định là 'name' và 'asc')
        $sortField = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');

        // Lấy danh sách user theo thứ tự đã chọn + phân trang
        $users = User::orderBy($sortField, $sortOrder)->paginate(5);

        // Kiểm tra điều kiện id_q
        foreach ($users as $user) {
            if (in_array($user->id_q, [3, 5])) {
                $user->displayName = $user->name;
            } else {
                // Lấy tên cán bộ từ bảng canbo dựa trên id_cb
                $canBo = CanBo::find($user->id_cb);
                $user->displayName = $canBo ? $canBo->hoten : 'Không xác định';
            }
        }

        // Lấy danh sách quyền và đơn vị cho modal thêm tài khoản
        $quyens = Quyen::all();
        $donvis = DonVi::all();

        return view('users.user', compact('users', 'sortField', 'sortOrder', 'quyens', 'donvis'));
    }

    /**
     * Hiển thị form thêm tài khoản
     */
    public function create()
    {
        // Lấy danh sách quyền để hiển thị trong form
        $quyens = Quyen::all();
        
        // Lấy danh sách đơn vị để hiển thị trong form khi thêm cán bộ
        $donvis = DonVi::all();
        
        return view('users.create', compact('quyens', 'donvis'));
    }

    /**
     * Lưu thông tin tài khoản mới
     */
    public function store(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'id_q' => 'required|exists:quyen,id_q',
            ]);

            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();
            
            // Tạo tài khoản user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'id_q' => $validated['id_q'],
            ]);
            
            // Nếu id_q khác 3 và 5, thêm thông tin cán bộ
            if (!in_array($user->id_q, [3, 5])) {
                // Validate dữ liệu cán bộ
                $validatedCanBo = $request->validate([
                    'hoten' => 'required|string|max:255',
                    'sdt' => 'required|string|max:20',
                    'email_cb' => 'required|string|email|max:255',
                    'diachi' => 'required|string|max:255',
                    'id_dv' => 'required|exists:donvi,id_dv',
                ]);
                
                // Tạo cán bộ mới
                $canBo = CanBo::create([
                    'hoten' => $validatedCanBo['hoten'],
                    'sdt' => $validatedCanBo['sdt'],
                    'email' => $validatedCanBo['email_cb'],
                    'diachi' => $validatedCanBo['diachi'],
                    'id_dv' => $validatedCanBo['id_dv'],
                ]);
                
                // Cập nhật id_cb vào user
                $user->id_cb = $canBo->id_cb;
                $user->save();
            }
            
            // Commit transaction
            DB::commit();
            
            // Kiểm tra nếu là request AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tài khoản đã được tạo thành công.',
                    'data' => $user
                ]);
            }
            
            // Nếu không phải AJAX request, redirect như bình thường
            return redirect()->route('users.index')
                ->with('success', 'Tài khoản đã được tạo thành công.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback nếu có lỗi validation
            if (isset($user)) {
                DB::rollBack();
            }
            
            // Trả về lỗi validation dưới dạng JSON nếu là AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            
            // Nếu không phải AJAX, xử lý như cũ
            throw $e;
        } catch (\Exception $e) {
            // Rollback nếu có lỗi xảy ra
            DB::rollBack();
            
            // Trả về lỗi dưới dạng JSON nếu là AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã xảy ra lỗi khi tạo tài khoản: ' . $e->getMessage()
                ], 500);
            }
            
            // Nếu không phải AJAX, xử lý như cũ
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Đã xảy ra lỗi khi tạo tài khoản: ' . $e->getMessage()]);
        }
    }
}
