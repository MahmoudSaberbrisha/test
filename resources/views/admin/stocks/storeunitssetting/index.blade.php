@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>إعدادات الوحدات</h1>
        <a href="{{ route('admin.storeunitssetting.create') }}" class="btn btn-primary">إضافة إعداد وحدة جديد</a>
    </div>

    <div class="row">
        @foreach ($unitssettings as $setting)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storeunitssetting.show', $setting->id) }}"
                            class="text-white text-decoration-none">
                            {{ $setting->unit_name }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <p><strong>الوصف:</strong> {{ $setting->description }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storeunitssetting.edit', $setting->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storeunitssetting.destroy', $setting->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('هل أنت متأكد؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
