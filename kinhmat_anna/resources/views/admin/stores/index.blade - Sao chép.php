@extends('layouts.admin') 

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Quản lý Cửa hàng</h3>
        <a href="{{ route('admin.stores.create') }}" class="btn btn-dark rounded-pill px-4 fw-bold">+ Thêm Chi Nhánh</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">Tên cửa hàng</th>
                        <th>Khu vực</th>
                        <th>Điện thoại</th>
                        <th>Giờ mở cửa</th>
                        <th class="text-end px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr>
                            <td class="px-4 fw-bold">
                                {{ $store->name }}<br>
                                <small class="text-muted fw-normal">{{ $store->address }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $store->city ?? 'Chưa cập nhật' }}</span></td>
                            <td>{{ $store->phone }}</td>
                            <td>{{ $store->open_time }}</td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('Chắc chắn xóa cửa hàng này?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Chưa có cửa hàng nào. Vui lòng bấm "Thêm Chi Nhánh".</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection