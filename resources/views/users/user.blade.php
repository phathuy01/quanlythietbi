@extends('layouts.app')
@section('title', 'List Users')
@section('main')
<div class="bg-white shadow-sm z-20 sticky top-0">
    <div class="container mx-auto px-4 py-4">
        <header class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-10">List Users</h1>
        </header>
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-2">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search name..." class="border p-2 rounded w-full">
                <button id="clearInput" class="bg-gray-100 hover:bg-gray-200 p-2 rounded-md">Clear</button>
            </div>
            <div class="flex space-x-2">
                <button id="openCreateModal" class="bg-blue-500 p-2 rounded-md text-white hover:bg-blue-800 flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5" fill="currentColor" stroke="currentColor">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
                    </svg>
                    <span>Create</span>
                </button>
                <a href="#" class="bg-red-500 p-2 rounded-md text-white hover:bg-red-800 flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5" fill="currentColor" stroke="currentColor">
                        <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                    <span>Delete</span>
                </a>
                <button class="border p-2 rounded bg-gray-200 hover:bg-gray-300">Filter</button>
            </div>
        </div>

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border p-2">
                        <input type="checkbox" id="checkAll" class="w-5 h-5 border-2 border-gray-500 rounded-md focus:ring-2 focus:ring-blue-500">
                    </th>
                    <th class="border p-4">Number order</th>
                    <th class="border p-4">
                        <a href="{{ route('users.index', ['sort' => 'id', 'order' => $sortField === 'id' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex justify-center items-center space-x-2">
                            <span>ID</span>
                            <div class="flex flex-col items-center -space-y-1 text-[12px]">
                                <span class="{{ $sortField === 'id' && $sortOrder === 'asc' ? 'text-blue-500' : 'text-gray-400' }}">🔼</span>
                                <span class="{{ $sortField === 'id' && $sortOrder === 'desc' ? 'text-blue-500' : 'text-gray-400' }}">🔽</span>
                            </div>
                        </a>
                    </th>
                    <th class="border p-4">
                        <a href="{{ route('users.index', ['sort' => 'name', 'order' => $sortField === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex justify-center items-center space-x-2">
                            <span>Name</span>
                            <div class="flex flex-col items-center -space-y-1 text-[12px]">
                                <span class="{{ $sortField === 'name' && $sortOrder === 'asc' ? 'text-blue-500' : 'text-gray-400' }}">🔼</span>
                                <span class="{{ $sortField === 'name' && $sortOrder === 'desc' ? 'text-blue-500' : 'text-gray-400' }}">🔽</span>
                            </div>
                        </a>
                    </th>
                    <th class="border p-4">
                        <a href="{{ route('users.index', ['sort' => 'email', 'order' => $sortField === 'email' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex justify-center items-center space-x-2">
                            <span>Email</span>
                            <div class="flex flex-col items-center -space-y-1 text-[12px]">
                                <span class="{{ $sortField === 'email' && $sortOrder === 'asc' ? 'text-blue-500' : 'text-gray-400' }}">🔼</span>
                                <span class="{{ $sortField === 'email' && $sortOrder === 'desc' ? 'text-blue-500' : 'text-gray-400' }}">🔽</span>
                            </div>
                        </a>
                    </th>
                    <th class="border p-4">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @if ($users->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No data</td>
                </tr>
                @endif
                @foreach ($users as $user)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-100">
                    <td class="border border-gray-300 p-4 text-center"><input type="checkbox" class="w-5 h-5 border-2 border-gray-500 rounded-md focus:ring-2 focus:ring-blue-500"></td>
                    <td class="border border-gray-300 p-4 text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td class="border border-gray-300 p-4 text-center">{{ $user->id }}</td>
                    <td class="border border-gray-300 p-4">{{ $user->displayName }}</td>
                    <td class="border border-gray-300 p-4">{{ $user->email }}</td>
                    <td class="border border-gray-300 p-4 flex justify-evenly">
                        <a href="{{ route('profile.update') }}" class="bg-blue-500 p-2 rounded-md text-white hover:bg-blue-800 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5" fill="currentColor" stroke="currentColor">
                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                            </svg>
                            <span>Update</span></a>
                        <a href="{{ route('profile.destroy') }}" class="bg-red-500 p-2 rounded-md text-white hover:bg-red-800 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5" fill="currentColor" stroke="currentColor">
                                <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                            </svg>
                            <span>Delete</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
        </table>
        <div class="flex justify-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal Thêm Tài Khoản -->
<div id="createUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border shadow-lg rounded-md bg-white max-w-4xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Thêm Tài Khoản Mới</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div id="formErrors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul id="errorList" class="list-disc pl-5"></ul>
        </div>

        <form id="createUserForm" class="space-y-4">
            @csrf
            
            <div class="bg-white p-4 rounded shadow border">
                <h4 class="text-md font-semibold mb-3">Thông tin tài khoản</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên người dùng *</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" required
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
                            <option value="{{ $quyen->id_q }}">{{ $quyen->ten_q }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Phần thông tin cán bộ, chỉ hiển thị khi id_q khác 3 và 5 -->
            <div id="canBoInfo" class="bg-white p-4 rounded shadow border hidden">
                <h4 class="text-md font-semibold mb-3">Thông tin cán bộ</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hoten" class="block text-sm font-medium text-gray-700">Họ tên cán bộ *</label>
                        <input type="text" name="hoten" id="hoten"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="sdt" class="block text-sm font-medium text-gray-700">Số điện thoại *</label>
                        <input type="text" name="sdt" id="sdt"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email_cb" class="block text-sm font-medium text-gray-700">Email cán bộ *</label>
                        <input type="email" name="email_cb" id="email_cb"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="diachi" class="block text-sm font-medium text-gray-700">Địa chỉ *</label>
                        <input type="text" name="diachi" id="diachi"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="id_dv" class="block text-sm font-medium text-gray-700">Đơn vị *</label>
                        <select name="id_dv" id="id_dv"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Chọn đơn vị --</option>
                            @foreach($donvis as $donvi)
                            <option value="{{ $donvi->id_dv }}">{{ $donvi->ten_dv }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <button type="button" id="cancelCreate" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Hủy
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function filterTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let rows = document.querySelectorAll("#tableBody tr");
        rows.forEach(row => {
            let name = row.cells[3].innerText.toLowerCase();
            row.style.display = name.includes(input) ? "" : "none";
        });
    }
    document.getElementById("clearInput").addEventListener("click", () => {
        document.getElementById("searchInput").value = "";
        filterTable();
    });

    document.getElementById("checkAll").addEventListener("click", () => {
        let checks = document.querySelectorAll("#tableBody input[type='checkbox']");
        checks.forEach(check => {
            check.checked = document.getElementById("checkAll").checked;
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById("checkAll");
        const checkboxes = document.querySelectorAll("#tableBody input[type='checkbox']");
        const modal = document.getElementById("createUserModal");
        const openModalBtn = document.getElementById("openCreateModal");
        const closeModalBtn = document.getElementById("closeModal");
        const cancelBtn = document.getElementById("cancelCreate");
        const createForm = document.getElementById("createUserForm");
        const idQSelect = document.getElementById("id_q");
        const canBoInfo = document.getElementById("canBoInfo");
        const formErrors = document.getElementById("formErrors");
        const errorList = document.getElementById("errorList");

        // Mở modal
        openModalBtn.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        // Đóng modal
        function closeModal() {
            modal.classList.add("hidden");
            createForm.reset();
            formErrors.classList.add("hidden");
            errorList.innerHTML = "";
        }

        closeModalBtn.addEventListener("click", closeModal);
        cancelBtn.addEventListener("click", closeModal);

        // Đóng modal khi click bên ngoài
        modal.addEventListener("click", function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Xử lý hiển thị/ẩn form thông tin cán bộ dựa trên id_q
        function toggleCanBoInfo() {
            const selectedValue = parseInt(idQSelect.value);
            const canBoFields = canBoInfo.querySelectorAll('input, select');
            
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
        
        // Khi thay đổi giá trị của id_q
        idQSelect.addEventListener('change', toggleCanBoInfo);

        // Xử lý submit form
        createForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu form
            const formData = new FormData(createForm);
            
            // Gửi request Ajax
            fetch("{{ route('users.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Nếu thành công, đóng modal và refresh trang
                    closeModal();
                    window.location.reload();
                } else {
                    // Hiển thị lỗi
                    formErrors.classList.remove("hidden");
                    errorList.innerHTML = "";
                    
                    if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            const li = document.createElement("li");
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement("li");
                        li.textContent = data.message || "Có lỗi xảy ra. Vui lòng thử lại.";
                        errorList.appendChild(li);
                    }
                }
            })
            .catch(error => {
                console.error("Error:", error);
                formErrors.classList.remove("hidden");
                errorList.innerHTML = "<li>Có lỗi xảy ra khi xử lý yêu cầu. Vui lòng thử lại.</li>";
            });
        });

        //Khôi phục trạng thái khi load trang
        const selectedUsers = JSON.parse(localStorage.getItem("selectedUsers")) || [];
        checkboxes.forEach(checkbox => {
            if (selectedUsers.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });

        //Cập nhật trạng thái của "Check All"
        checkAll.checked = checkboxes.length > 0 && [...checkboxes].every(checkbox => checkbox.checked);

        //Sự kiện khi nhấn vào "Check All"
        checkAll.addEventListener("change", function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
                updateStorage();
            });
        });

        //Sự kiện khi chọn từng checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                updateStorage();
                checkAll.checked = [...checkboxes].every(checkbox => checkbox.checked);
            });
        });

        //Hàm cập nhật danh sách checkbox đã chọn vào localStorage
        function updateStorage() {
            const selected = [...checkboxes].filter(c => c.checked).map(c => c.value);
            localStorage.setItem("selectedUsers", JSON.stringify(selected));
        }
    });
</script>
@endsection