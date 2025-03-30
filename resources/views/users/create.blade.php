@extends('layouts.app')
@section('title', 'Thêm Tài Khoản Mới')
@section('main')
<div class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4">
        <header class="mb-5">
            <h1 class="text-2xl font-bold">Thêm Tài Khoản Mới</h1>
            <p class="text-gray-500">Điền thông tin để tạo tài khoản mới</p>
        </header>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" id="createUserForm" class="space-y-6">
            @csrf
            
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-4">Thông tin tài khoản</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên người dùng *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu *</label>
                        <input type="password" name="password" id="password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="id_q" class="block text-sm font-medium text-gray-700">Quyền *</label>
                        <select name="id_q" id="id_q" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Chọn quyền --</option>
                            @foreach($quyens as $quyen)
                            <option value="{{ $quyen->id_q }}" {{ old('id_q') == $quyen->id_q ? 'selected' : '' }}>
                                {{ $quyen->ten_q }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Phần thông tin cán bộ, chỉ hiển thị khi id_q khác 3 và 5 -->
            <div id="canBoInfo" class="bg-white p-4 rounded shadow hidden">
                <h2 class="text-lg font-semibold mb-4">Thông tin cán bộ</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hoten" class="block text-sm font-medium text-gray-700">Họ tên cán bộ *</label>
                        <input type="text" name="hoten" id="hoten" value="{{ old('hoten') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="sdt" class="block text-sm font-medium text-gray-700">Số điện thoại *</label>
                        <input type="text" name="sdt" id="sdt" value="{{ old('sdt') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email_cb" class="block text-sm font-medium text-gray-700">Email cán bộ *</label>
                        <input type="email" name="email_cb" id="email_cb" value="{{ old('email_cb') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="diachi" class="block text-sm font-medium text-gray-700">Địa chỉ *</label>
                        <input type="text" name="diachi" id="diachi" value="{{ old('diachi') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="id_dv" class="block text-sm font-medium text-gray-700">Đơn vị *</label>
                        <select name="id_dv" id="id_dv"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Chọn đơn vị --</option>
                            @foreach($donvis as $donvi)
                            <option value="{{ $donvi->id_dv }}" {{ old('id_dv') == $donvi->id_dv ? 'selected' : '' }}>
                                {{ $donvi->ten_dv }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript để hiển thị/ẩn form thông tin cán bộ dựa trên id_q
    document.addEventListener('DOMContentLoaded', function() {
        const idQSelect = document.getElementById('id_q');
        const canBoInfo = document.getElementById('canBoInfo');
        const canBoFields = canBoInfo.querySelectorAll('input, select');
        
        function toggleCanBoInfo() {
            const selectedValue = parseInt(idQSelect.value);
            
            if (selectedValue === 3 || selectedValue === 5) {
                canBoInfo.classList.add('hidden');
                // Disable các trường thông tin cán bộ
                canBoFields.forEach(field => {
                    field.disabled = true;
                    field.required = false;
                });
            } else {
                canBoInfo.classList.remove('hidden');
                // Enable các trường thông tin cán bộ
                canBoFields.forEach(field => {
                    field.disabled = false;
                    field.required = true;
                });
            }
        }
        
        // Khi trang tải, kiểm tra giá trị ban đầu
        if (idQSelect.value) {
            toggleCanBoInfo();
        }
        
        // Khi thay đổi giá trị của id_q
        idQSelect.addEventListener('change', toggleCanBoInfo);
    });
</script>
@endsection 