@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل تحويل صنف</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>المعرف:</strong> {{ $record->id }}</p>
            <p><strong>رقم الإرسال:</strong> {{ $record->rkm_fk }}</p>
            <p><strong>معرف الصنف:</strong> {{ $record->sanf_id }}</p>
            <p><strong>اسم الصنف:</strong> {{ $record->sanf_n }}</p>
            <p><strong>كود الصنف:</strong> {{ $record->sanf_code }}</p>
            <p><strong>الكمية المتاحة:</strong> {{ $record->amount_motah }}</p>
            <p><strong>الكمية المرسلة:</strong> {{ $record->amount_send }}</p>
            <p><strong>من المخزن:</strong> {{ $record->from_storage }}</p>
            <p><strong>إلى المخزن:</strong> {{ $record->to_storage }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storetahwelatasnaf.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storetahwelatasnaf.edit', $record->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
