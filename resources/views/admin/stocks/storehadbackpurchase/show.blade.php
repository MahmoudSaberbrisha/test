@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل عملية شراء مرتجعة</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>رقم الفرع الرئيسي:</strong> {{ $hadback->main_branch_id_fk }}</p>
            <p><strong>رقم الفرع الفرعي:</strong> {{ $hadback->sub_branch_id_fk }}</p>
            <p><strong>كود المورد:</strong> {{ $hadback->supplier_code }}</p>
            <p><strong>كود الفاتورة:</strong> {{ $hadback->fatora_code }}</p>
            <p><strong>كود المنتج:</strong> {{ $hadback->product_code }}</p>
            <p><strong>كمية الشراء:</strong> {{ $hadback->amount_buy }}</p>
            <p><strong>إجمالي تكلفة الشراء:</strong> {{ $hadback->all_cost_buy }}</p>
            <p><strong>سعر الشراء للوحدة:</strong> {{ $hadback->one_price_sell }}</p>
            <p><strong>كمية المرتجع:</strong> {{ $hadback->hadback_amount }}</p>
            <p><strong>التاريخ:</strong> {{ $hadback->date }}</p>
            <p><strong>التاريخ S:</strong> {{ $hadback->date_s }}</p>
            <p><strong>رقم الناشر:</strong> {{ $hadback->publisher }}</p>
        </div>
    </div>

    <a href="{{ route('storehadbackpurchase.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('storehadbackpurchase.edit', $hadback->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
