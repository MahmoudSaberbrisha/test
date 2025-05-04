@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل مشتريات المخزن الأخرى</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>المعرف:</strong> {{ $purchase->id }}</p>
            <p><strong>معرف الفرع الرئيسي:</strong> {{ $purchase->main_branch_id_fk }}</p>
            <p><strong>معرف الفرع الفرعي:</strong> {{ $purchase->sub_branch_id_fk }}</p>
            <p><strong>كود المنتج:</strong> {{ $purchase->product_code }}</p>
            <p><strong>اسم المنتج:</strong> {{ $purchase->product_name }}</p>
            <p><strong>كمية الشراء:</strong> {{ $purchase->amount_buy }}</p>
            <p><strong>التكلفة الكلية للشراء:</strong> {{ $purchase->all_cost_buy }}</p>
            <p><strong>سعر البيع الواحد:</strong> {{ $purchase->one_price_sell }}</p>
            <p><strong>سعر الشراء الواحد:</strong> {{ $purchase->one_price_buy }}</p>
            <p><strong>رصيد متاح:</strong> {{ $purchase->rasid_motah }}</p>
            <p><strong>كود الفاتورة:</strong> {{ $purchase->fatora_code }}</p>
            <p><strong>تاريخ الفاتورة:</strong> {{ $purchase->fatora_date }}</p>
            <p><strong>تاريخ طباعة الفاتورة:</strong> {{ $purchase->fatora_print_date }}</p>
            <p><strong>الناشر:</strong> {{ $purchase->publisher }}</p>
            <p><strong>مرتجع:</strong> {{ $purchase->had_back }}</p>
            <p><strong>مبلغ المرتجع:</strong> {{ $purchase->had_back_amount }}</p>
            <p><strong>تاريخ المرتجع:</strong> {{ $purchase->had_back_date }}</p>
            <p><strong>التاريخ (عربي):</strong> {{ $purchase->date_ar }}</p>
            <p><strong>قديم:</strong> {{ $purchase->old ? 'نعم' : 'لا' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.storepurchasesothers.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.storepurchasesothers.edit', $purchase->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
