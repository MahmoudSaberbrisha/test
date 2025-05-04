@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل رصيد عيني</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>المعرف:</strong> {{ $record->id }}</p>
            <p><strong>رقم الفرع الرئيسي:</strong> {{ $record->main_branch_id_fk }}</p>
            <p><strong>رقم الفرع الفرعي:</strong> {{ $record->sub_branch_id_fk }}</p>
            <p><strong>التاريخ:</strong> {{ $record->date }}</p>
            <p><strong>التاريخ بالعربي:</strong> {{ $record->date_ar }}</p>
            <p><strong>اسم الناشر:</strong> {{ $record->publisher_name }}</p>
            <p><strong>الناشر:</strong> {{ $record->publisher }}</p>
            <p><strong>كود الصنف:</strong> {{ $record->sanf_code }}</p>
            <p><strong>معرف الصنف:</strong> {{ $record->sanf_id }}</p>
            <p><strong>اسم الصنف:</strong> {{ $record->sanf_name }}</p>
            <p><strong>كمية الصنف:</strong> {{ $record->sanf_amount }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storerasidayni.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storerasidayni.edit', $record->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
