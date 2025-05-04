@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>مشتريات المخزن الأخرى</h1>
        <a href="{{ route('admin.storepurchasesothers.create') }}" class="btn btn-primary">إضافة مشتريات أخرى جديدة</a>
    </div>

    <div class="row">
        @foreach ($purchases as $purchase)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storepurchasesothers.show', $purchase->id) }}"
                            class="text-white text-decoration-none">
                            {{ $purchase->main_branch_id_fk }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $purchase->id }}</div>
                            <div class="col-6"><strong>معرف الفرع الرئيسي:</strong> {{ $purchase->main_branch_id_fk }}
                            </div>
                            <div class="col-6"><strong>معرف الفرع الفرعي:</strong> {{ $purchase->sub_branch_id_fk }}</div>
                            <div class="col-6"><strong>كود المنتج:</strong> {{ $purchase->product_code }}</div>
                            <div class="col-6"><strong>اسم المنتج:</strong> {{ $purchase->product_name }}</div>
                            <div class="col-6"><strong>كمية الشراء:</strong> {{ $purchase->amount_buy }}</div>
                            <div class="col-6"><strong>التكلفة الكلية للشراء:</strong> {{ $purchase->all_cost_buy }}</div>
                            <div class="col-6"><strong>سعر البيع الواحد:</strong> {{ $purchase->one_price_sell }}</div>
                            <div class="col-6"><strong>سعر الشراء الواحد:</strong> {{ $purchase->one_price_buy }}</div>
                            <div class="col-6"><strong>رصيد متاح:</strong> {{ $purchase->rasid_motah }}</div>
                            <div class="col-6"><strong>كود الفاتورة:</strong> {{ $purchase->fatora_code }}</div>
                            <div class="col-6"><strong>تاريخ الفاتورة:</strong> {{ $purchase->date_s }}</div>
                            <div class="col-6"><strong>التاريخ (عربي):</strong> {{ $purchase->date_ar }}</div>
                            <div class="col-6"><strong>الناشر:</strong> {{ $purchase->publisher }}</div>
                            <div class="col-6"><strong>مرتجع:</strong> {{ $purchase->had_back }}</div>
                            <div class="col-6"><strong>تاريخ المرتجع:</strong> {{ $purchase->had_back_date }}</div>
                            <div class="col-6"><strong>مبلغ المرتجع:</strong> {{ $purchase->had_back_amount }}</div>
                            <div class="col-6"><strong>قديم:</strong> {{ $purchase->old ? 'نعم' : 'لا' }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storepurchasesothers.edit', $purchase->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storepurchasesothers.destroy', $purchase->id) }}" method="POST"
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
