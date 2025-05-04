@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>تحويلات الأصناف</h1>
        <a href="{{ route('admin.storetahwelatasnaf.create') }}" class="btn btn-primary">إضافة تحويل صنف جديد</a>
    </div>

    <div class="row">
        @foreach ($tahwelatasnaf as $record)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storetahwelatasnaf.show', $record->id) }}"
                            class="text-white text-decoration-none">
                            {{ $record->rkm_fk }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $record->id }}</div>
                            <div class="col-6"><strong>رقم الإرسال:</strong> {{ $record->rkm_fk }}</div>
                            <div class="col-6"><strong>معرف الصنف:</strong> {{ $record->sanf_id }}</div>
                            <div class="col-6"><strong>اسم الصنف:</strong> {{ $record->sanf_n }}</div>
                            <div class="col-6"><strong>كود الصنف:</strong> {{ $record->sanf_code }}</div>
                            <div class="col-6"><strong>الكمية المتاحة:</strong> {{ $record->amount_motah }}</div>
                            <div class="col-6"><strong>الكمية المرسلة:</strong> {{ $record->amount_send }}</div>
                            <div class="col-6"><strong>من المخزن:</strong> {{ $record->from_storage }}</div>
                            <div class="col-6"><strong>إلى المخزن:</strong> {{ $record->to_storage }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storetahwelatasnaf.edit', $record->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storetahwelatasnaf.destroy', $record->id) }}" method="POST"
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
