@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content')

{{-- CSS Custom cho trang Users --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    /* Table Styles */
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e3e6f0;
        padding: 16px;
        white-space: nowrap;
    }

    .table-modern tbody td {
        vertical-align: middle;
        padding: 16px;
        border-top: 1px solid #f0f1f5;
        color: #5a5c69;
    }

    .table-modern tbody tr {
        transition: all 0.2s;
    }

    .table-modern tbody tr:hover {
        background-color: #fafbfc;
        /* Đã bỏ transform scale để tránh lỗi hiển thị border table */
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    /* Avatar Circle */
    .avatar-circle {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        margin-right: 12px;
        box-shadow: 0 2px 5px rgba(78, 115, 223, 0.2);
    }

    /* Badges (Soft Style) */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; }
    .bg-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #36b9cc; }

    /* Buttons */
    .btn-action {
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* ID Badge */
    .id-badge {
        font-family: 'Courier New', monospace;
        background: #f1f3f9;
        padding: 4px 8px;
        border-radius: 6px;
        color: #4e73df;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-users-cog text-primary mr-2"></i>Quản lý Người dùng
        </h1>
        <a href="{{ route('admin.users.create') }}"
           class="btn btn-primary btn-action shadow-sm"
           style="border-radius: 50px; padding: 8px 20px;">
            <i class="fas fa-plus-circle mr-2"></i> Thêm Người dùng
        </a>
    </div>

    <div class="card card-modern mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0" id="usersTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">ID</th>
                            <th>Tên hiển thị</th>
                            <th>Email đăng nhập</th>
                            <th class="text-center">Vai trò</th>
                            <th>Ngày tham gia</th>
                            <th class="text-center" width="280">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($users as $user)
                        <tr @if(!$user->is_active) class="table-danger" @endif>

                            {{-- ID --}}
                            <td class="text-center">
                                <span class="id-badge">#{{ $user->id }}</span>
                            </td>

                            {{-- Name --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle">
                                        {{-- SỬA: Dùng mb_ để hỗ trợ tiếng Việt --}}
                                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                        @if(!$user->is_active)
                                            <span class="badge badge-soft bg-soft-danger mt-1">Đã khóa</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="text-muted">{{ $user->email }}</td>

                            {{-- Role --}}
                            <td class="text-center">
                                @if($user->is_admin)
                                    <span class="badge badge-soft bg-soft-danger">
                                        <i class="fas fa-user-shield mr-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge badge-soft bg-soft-info">
                                        <i class="fas fa-user mr-1"></i> User
                                    </span>
                                @endif
                            </td>

                            {{-- Created --}}
                            <td class="text-muted small">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center">

                                    @if(Auth::id() === $user->id)
                                        <span class="badge bg-light text-secondary border px-3 py-2">
                                            <i class="fas fa-user-circle mr-1"></i> Bạn
                                        </span>
                                    @else

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-outline-primary btn-sm btn-action mr-1">
                                            <i class="fas fa-edit"></i> sửa
                                        </a>

                                        {{-- Admin / User --}}
                                        @if(!$user->is_admin)
                                            <form action="{{ route('admin.users.make-admin', $user) }}" method="POST" class="d-inline-block mr-1">
                                                @csrf
                                                <button class="btn btn-outline-success btn-sm btn-action">
                                                    <i class="fas fa-arrow-up"></i> admin
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.revoke-admin', $user) }}" method="POST" class="d-inline-block mr-1">
                                                @csrf
                                                <button class="btn btn-outline-warning btn-sm btn-action">
                                                    <i class="fas fa-arrow-down"></i> user
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Lock / Unlock --}}
                                        @if($user->is_active)
                                            {{-- KHÓA TÀI KHOẢN --}}
                                            {{-- SỬA: Đổi route sang 'lock' và bỏ @method('DELETE') --}}
                                            <form action="{{ route('admin.users.lock', $user) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm btn-action"
                                                        onclick="return confirm('Bạn có chắc muốn khóa tài khoản {{ $user->name }} không? User này sẽ không thể đăng nhập.')">
                                                    <i class="fas fa-lock"></i> khóa
                                                </button>
                                            </form>
                                        @else
                                            {{-- MỞ KHÓA --}}
                                            <form action="{{ route('admin.users.unlock', $user) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-outline-success btn-sm btn-action">
                                                    <i class="fas fa-unlock"></i> mở
                                                </button>
                                            </form>
                                        @endif

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            paging: true,       // Bật phân trang để tránh lag
            pageLength: 10,     // 10 dòng mỗi trang
            searching: true,
            info: true,
            ordering: true,
            lengthChange: false, // Ẩn nút chọn số dòng
            language: {
                "decimal":        "",
                "emptyTable":     "Không có dữ liệu",
                "info":           "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ thành viên",
                "infoEmpty":      "Hiển thị 0 đến 0 trong tổng số 0 thành viên",
                "infoFiltered":   "(lọc từ _MAX_ thành viên)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Hiển thị _MENU_ dòng",
                "loadingRecords": "Đang tải...",
                "processing":     "Đang xử lý...",
                "search":         "",
                "searchPlaceholder": "Tìm kiếm thành viên...",
                "zeroRecords":    "Không tìm thấy kết quả",
                "paginate": {
                    "first":      "Đầu",
                    "last":       "Cuối",
                    "next":       '<i class="fas fa-chevron-right"></i>',
                    "previous":   '<i class="fas fa-chevron-left"></i>'
                }
            },
            columnDefs: [
                { orderable: false, targets: [5] } // Tắt sắp xếp cột Hành động
            ]
        });
    });
</script>
@endsection