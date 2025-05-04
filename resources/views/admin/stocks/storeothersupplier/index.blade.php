@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>تخزين الموردين الآخرين</h1>
        <a href="{{ route('admin.storeothersupplier.create') }}" class="btn btn-primary">إضافة مورد جديد</a>
    </div>

    <div class="row">
        @foreach ($suppliers as $supplier)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storeothersupplier.show', $supplier->id) }}"
                            class="text-white text-decoration-none">
                            {{ $supplier->name }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>ID:</strong> {{ $supplier->id }}</div>
                            <div class="col-6"><strong>Code:</strong> {{ $supplier->code }}</div>
                            <div class="col-6"><strong>Supplier Address:</strong> {{ $supplier->supplier_address }}</div>
                            <div class="col-6"><strong>Supplier Phone:</strong> {{ $supplier->supplier_phone }}</div>
                            <div class="col-6"><strong>Supplier Fax:</strong> {{ $supplier->supplier_fax }}</div>
                            <div class="col-6"><strong>Accountant Name:</strong> {{ $supplier->accountant_name }}</div>
                            <div class="col-6"><strong>Accountant Telephone:</strong> {{ $supplier->accountant_telephone }}
                            </div>
                            <div class="col-6"><strong>Supplier Dayen:</strong> {{ $supplier->supplier_dayen }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storeothersupplier.edit', $supplier->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storeothersupplier.destroy', $supplier->id) }}" method="POST"
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
