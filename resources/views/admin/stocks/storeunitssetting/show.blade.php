@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل إعداد الوحدة</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>اسم الوحدة:</strong> {{ $setting->unit_name }}</p>
            <p><strong>الوصف:</strong> {{ $setting->description }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storeunitssetting.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storeunitssetting.edit', $setting->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
