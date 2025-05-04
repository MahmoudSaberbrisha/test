@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل الخزينة</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>الاسم:</strong> {{ $khazina->name }}</p>
            <p><strong>الفرع الرئيسي:</strong> {{ $khazina->mainBranch->title ?? 'غير معروف' }}</p>
            <p><strong>الفرع الفرعي:</strong> {{ $khazina->subBranch->title ?? 'غير معروف' }}</p>
            <p><strong>الوصف:</strong> {{ $khazina->description }}</p>
            <p><strong>الرصيد:</strong> {{ $khazina->balance }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storekhazina.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storekhazina.edit', $khazina->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
