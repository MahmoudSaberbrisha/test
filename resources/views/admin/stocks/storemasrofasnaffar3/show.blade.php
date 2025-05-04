@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل مصروف أصناف فرع</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>المعرف:</strong> {{ $record->id }}</p>
            <p><strong>الفرع الرئيسي:</strong> {{ $record->mainBranch->title ?? 'غير معروف' }}</p>
            <p><strong>الفرع الفرعي:</strong> {{ $record->subBranch->title ?? 'غير معروف' }}</p>
            <p><strong>رقم الصرف:</strong> {{ $record->sarf_rkm }}</p>
            <p><strong>الصرف إلى:</strong> {{ $record->sarf_to }}</p>
            <p><strong>كود الصنف:</strong> {{ $record->sanf_code }}</p>
            <p><strong>الكمية المتاحة:</strong> {{ $record->available_amount }}</p>
            <p><strong>كمية الصنف:</strong> {{ $record->sanf_amount }}</p>
            <p><strong>سعر البيع للوحدة:</strong> {{ $record->one_price_sell }}</p>
            <p><strong>التاريخ:</strong> {{ $record->date }}</p>
            <p><strong>التاريخ بالعربي:</strong> {{ $record->date_ar }}</p>
            <p><strong>الناشر:</strong> {{ $record->publisher }}</p>
            <p><strong>اسم الناشر:</strong> {{ $record->publisher_name }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storemasrofasnaffar3.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storemasrofasnaffar3.edit', $record->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
