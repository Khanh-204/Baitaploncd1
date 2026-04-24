<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class AdminStoreController extends Controller
{
    // Danh sách cửa hàng
    public function index()
    {
        $stores = Store::latest()->get();
        return view('admin.stores.index', compact('stores'));
    }

    // Trang thêm cửa hàng
    public function create()
    {
        return view('admin.stores.create');
    }

 // Lưu cửa hàng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            // Bắt buộc là số, độ dài 9-11 ký tự
            'phone' => ['required', 'regex:/^[0-9]{9,11}$/'], 
            'open_time' => 'required|string|max:50',
            // Bắt buộc phải là định dạng URL chuẩn
            'map_url' => 'required|url' 
        ], [
            'phone.regex' => 'Số điện thoại không hợp lệ (phải từ 9-11 số).',
            'map_url.url' => 'Link bản đồ phải là một URL hợp lệ.'
        ]);

        Store::create($request->all());
        return redirect()->route('admin.stores.index')->with('success', 'Đã thêm chi nhánh thành công!');
    }
// Hiển thị form Sửa cửa hàng
    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    // Cập nhật dữ liệu cửa hàng
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'phone' => ['required', 'regex:/^[0-9]{9,11}$/'], 
            'open_time' => 'required|string|max:50',
            'map_url' => 'required|url' 
        ], [
            'phone.regex' => 'Số điện thoại không hợp lệ (phải từ 9-11 số).',
            'map_url.url' => 'Link bản đồ phải là một URL hợp lệ.'
        ]);

        $store->update($request->all());
        return redirect()->route('admin.stores.index')->with('success', 'Đã cập nhật thông tin chi nhánh thành công!');
    }
    // Xóa cửa hàng
    public function destroy(Store $store)
    {
        $store->delete();
        return back()->with('success', 'Đã xóa cửa hàng!');
    }
}