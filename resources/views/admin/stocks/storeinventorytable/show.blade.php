@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل سجل الجرد</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>العنصر:</strong> {{ $inventory->item_id_fk }}</p>
            <p><strong>الفئة:</strong> {{ $inventory->category }}</p>
            <p><strong>معرف التخزين:</strong> {{ $inventory->storage_id_fk }}</p>
            <p><strong>الكمية:</strong> {{ $inventory->amount }}</p>
            <p><strong>رقم الجرد:</strong> {{ $inventory->num_invent }}</p>
            <p><strong>الكمية المتوفرة:</strong> {{ $inventory->available_amount }}</p>
            <p><strong>تاريخ الجرد:</strong> {{ $inventory->invent_date }}</p>
            <p><strong>التاريخ:</strong> {{ $inventory->date }}</p>
            <p><strong>التاريخ (S):</strong> {{ $inventory->date_s }}</p>
            <p><strong>التاريخ (AR):</strong> {{ $inventory->date_ar }}</p>
            <p><strong>الناشر:</strong> {{ $inventory->publisher }}</p>
            <p><strong>الفرع الفرعي:</strong> {{ $inventory->sub_branch_id_fk }}</p>
            <p><strong>مقدار العجز:</strong> {{ $inventory->deficit_amount }}</p>
            <p><strong>مقدار الزيادة:</strong> {{ $inventory->increase_amount }}</p>
            <p><strong>ملاحظات:</strong> {{ $inventory->notes }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storeinventorytable.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storeinventorytable.edit', $inventory->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
