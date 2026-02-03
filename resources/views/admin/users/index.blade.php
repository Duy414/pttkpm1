@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Tài khoản / Khách hàng</h6>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm Người dùng
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="usersTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên hiển thị</th>
                        <th>Email đăng nhập</th>
                        <th>Vai trò (Role)</th>
                        <th>Ngày tham gia</th>
                        <th style="width: 250px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <span class="font-weight-bold">{{ $user->name }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{-- 👇 SỬA ĐỔI: Kiểm tra role thay vì is_admin --}}
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill px-3">
                                    <i class="fas fa-user-shield me-1"></i> Admin
                                </span>
                            @else
                                <span class="badge bg-info text-dark rounded-pill px-3">
                                    <i class="fas fa-user me-1"></i> User
                                </span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-start">
                                {{-- Nút Sửa --}}
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-sm btn-primary me-2" title="Sửa thông tin">
                                    <i class="fas fa-edit"></i>Sửa
                                </a>
                                
                                {{-- 👇 SỬA ĐỔI: Logic nút cấp/hủy quyền Admin --}}
                                {{-- Không cho phép tự hủy quyền hoặc xóa chính mình --}}
                                @if(Auth::id() !== $user->id)
                                
                                    @if($user->role !== 'admin')
                                        {{-- Nếu chưa là Admin -> Hiện nút Lên Admin --}}
                                        <form action="{{ route('admin.users.make-admin', $user) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Cấp quyền Admin">
                                                <i class="fas fa-arrow-up"></i> Admin
                                            </button>
                                        </form>
                                    @else
                                        {{-- Nếu đang là Admin -> Hiện nút Xuống User --}}
                                        <form action="{{ route('admin.users.revoke-admin', $user) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning" title="Thu hồi quyền Admin">
                                                <i class="fas fa-arrow-down"></i> User
                                            </button>
                                        </form>
                                    @endif
                                    
                                    {{-- Nút Xóa --}}
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('CẢNH BÁO: Bạn chắc chắn muốn xóa tài khoản {{ $user->name }}?')" 
                                                title="Xóa tài khoản">
                                            <i class="fas fa-trash"></i>Xóa
                                        </button>
                                    </form>

                                @else
                                    <span class="text-muted small"><i>(Tài khoản của bạn)</i></span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": false, // Tắt phân trang JS để dùng của Laravel
            "searching": true,
            "info": false,
            "ordering": true,
            "language": {
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "zeroRecords": "Không tìm thấy dữ liệu",
                "info": "Trang _PAGE_ / _PAGES_",
                "search": "Tìm kiếm nhanh:",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Tiếp",
                    "previous": "Trước"
                }
            }
        });
    });
</script>
@endsection