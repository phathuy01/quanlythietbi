@extends('layouts.app')
@section('title', 'Quản lý thiết bị')
@section('main')
<!-- Header -->
<div class="flex flex-col items-center justify-start min-h-screen bg-gray-100 p-5 w-full mt-12">
    <header class="text-center p-5 bg-white w-full max-w-[1000px] rounded-lg shadow-md mb-5">
        <h1 class="text-2xl font-bold text-black">QUẢN LÝ LOẠI THIẾT BỊ</h1>
        <p class="text-base text-black"><i class="fas fa-book"></i> <em>Tổng số bản ghi: {{ $loaiThietBis->total() }}</em></p>
    </header>

    <!-- Container chứa công cụ -->
    <div class="flex items-center justify-between gap-4 bg-white p-5 w-full max-w-[1000px] rounded-lg shadow-md">
        <!-- Search Input -->
        <div class="flex items-center gap-2">
            <input type="text" placeholder="Search name..." id="searchInput" onkeyup="searchTable()" class="w-[300px] p-2.5 border border-gray-300 rounded-md text-sm">
            <button class="bg-red-500 text-white border-none px-4 py-2.5 rounded-md text-sm flex items-center gap-2 hover:bg-red-600" onclick="clearSearch()">
                <i class="fas fa-times"></i> Clear
            </button>
        </div>

        <!-- Upload & Download Buttons -->
        <div class="flex gap-2.5">
            <button class="bg-green-500 text-white border-none px-4 py-2.5 rounded-md text-sm flex items-center gap-2 hover:bg-red-500">
                <i class="fas fa-upload"></i> Upload File
            </button>
            <button class="bg-green-500 text-white border-none px-4 py-2.5 rounded-md text-sm flex items-center gap-2 hover:bg-red-500">
                <i class="fas fa-download"></i> Download File
            </button>
            <button class="bg-green-500 text-white border-none px-4 py-2.5 rounded-md text-sm flex items-center gap-2 hover:bg-red-500" onclick="openForm()">
                <i class="fas fa-plus"></i> Insert
            </button>
        </div>

        <select class="border border-gray-300 p-2.5 rounded-md text-sm cursor-pointer" id="rowsPerPage" onchange="updateRowsPerPage()">
            <option value="5">5 rows/page</option>
            <option value="10">10 rows/page</option>
            <option value="15">15 rows/page</option>
            <option value="20">all rows/page</option>
        </select>
    </div>

    <!-- Table -->
    <div class="w-full mt-5 bg-white p-5 rounded-lg shadow-md overflow-x-auto max-w-[1000px]">
        <table id="deviceTable" class="w-full border-collapse text-base text-left max-w-[950px]">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="text-center p-3 border border-gray-300">STT</th>
                    <th class="text-center p-3 border border-gray-300">ID</th>
                    <th class="text-center p-3 border border-gray-300">TÊN LOẠI</th>
                    <th class="text-center p-3 border border-gray-300">MÔ TẢ</th>
                    <th class="text-center p-3 border border-gray-300">CHỨC NĂNG</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($loaiThietBis as $index => $loaiThietBi)
                <tr class="border border-gray-300">
                    <td class="p-3 border border-gray-300">{{ $index + 1 }}</td>
                    <td class="p-3 border border-gray-300">{{ $loaiThietBi->id_ltb }}</td>
                    <td class="p-3 border border-gray-300">{{ $loaiThietBi->ten_ltb }}</td>
                    <td class="p-3 border border-gray-300">{{ $loaiThietBi->mota }}</td>
                    <td class="p-3 border border-gray-300">
                        <div class="flex justify-center items-center gap-2">
                            <button class="bg-green-500 text-white border-none px-3 py-1.5 rounded-md text-sm flex items-center gap-1 hover:bg-green-600">
                                <i class="fas fa-edit"></i> Update
                            </button>
                            <button class="bg-red-500 text-white border-none px-3 py-1.5 rounded-md text-sm flex items-center gap-1 hover:bg-red-600">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $loaiThietBis->links() }}
    </div>

    <div id="insertForm" class="hidden fixed max-w-[600px] left-1/2 top-1/2 justify-center items-center flex-col transform -translate-x-1/2 -translate-y-1/2 bg-white p-5 shadow-lg rounded-lg">
        <h3 class="text-lg font-bold mb-4">Thêm Loại Thiết Bị</h3>
        <input type="text" id="tenLoai" placeholder="Tên loại" class="w-full p-2 mb-2 border border-gray-300 rounded-md text-base">
        <textarea id="moTa" placeholder="Mô tả" rows="4" cols="50" class="w-full p-2 mb-2 border border-gray-300 rounded-md text-base"></textarea>
        <br>
        <button class="bg-green-500 text-white border-none px-4 py-2 rounded-md cursor-pointer mt-2.5" onclick="closeForm()">
            <i class="fas fa-save"></i> Save
        </button>
        <button class="bg-red-500 text-white border-none px-4 py-2 rounded-md cursor-pointer mt-2.5" onclick="resetForm()">
            <i class="fas fa-undo"></i> Reset
        </button>
    </div>
</div>

<script>
    function openForm() {
        document.getElementById("insertForm").classList.remove("hidden");
    }

    function closeForm() {
        document.getElementById("insertForm").classList.add("hidden");
    }

    function resetForm() {
        document.getElementById("tenLoai").value = "";
        document.getElementById("moTa").value = "";
    }

    function updateRowsPerPage() {
        const perPage = document.getElementById("rowsPerPage").value;
        window.location.href = `{{ route('QuanLyThietBi.index') }}?per_page=${perPage}`;
    }

    function searchTable() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#deviceTable tbody tr");

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchInput) ? "" : "none";
        });
    }

    function clearSearch() {
        document.getElementById("searchInput").value = "";
        const rows = document.querySelectorAll("#deviceTable tbody tr");
        rows.forEach(row => row.style.display = "");
    }
</script>
@endsection