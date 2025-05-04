@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل مورد آخر</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>الكود:</strong> {{ $supplier->code }}</p>
            <p><strong>اسم المورد:</strong> {{ $supplier->name }}</p>
            <p><strong>عنوان المورد:</strong> {{ $supplier->supplier_address }}</p>
            <p><strong>هاتف المورد:</strong> {{ $supplier->supplier_phone }}</p>
            <p><strong>فاكس المورد:</strong> {{ $supplier->supplier_fax }}</p>
            <p><strong>اسم المحاسب:</strong> {{ $supplier->accountant_name }}</p>
            <p><strong>هاتف المحاسب:</strong> {{ $supplier->accountant_telephone }}</p>
            <p><strong>ديون المورد:</strong> {{ $supplier->supplier_dayen }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storeothersupplier.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storeothersupplier.edit', $supplier->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
