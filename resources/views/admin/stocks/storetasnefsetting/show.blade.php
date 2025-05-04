@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل إعداد التصنيف</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>الاسم:</strong> {{ $setting->name }}</p>
            <p><strong>النوع:</strong> {{ $setting->type }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storetasnefsetting.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storetasnefsetting.edit', $setting->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
