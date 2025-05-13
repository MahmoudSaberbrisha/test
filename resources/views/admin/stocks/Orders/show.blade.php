@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل الطلب</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>المعرف:</strong> {{ $requestRecord->id }}</p>
            <p><strong>معرف الفرع الرئيسي:</strong> {{ $requestRecord->main_branch_id_fk }}</p>
            <p><strong>معرف الفرع الفرعي:</strong> {{ $requestRecord->sub_branch_id_fk }}</p>
            <p><strong>كود المنتج:</strong> {{ $requestRecord->product_code }}</p>
            <p><strong>اسم المنتج:</strong> {{ $requestRecord->product_name }}</p>
            <p><strong>كمية الشراء:</strong> {{ $requestRecord->amount_buy }}</p>
            <p><strong>التكلفة الكلية للشراء:</strong> {{ $requestRecord->all_cost_buy }}</p>
            <p><strong>سعر البيع الواحد:</strong> {{ $requestRecord->one_price_sell }}</p>
            <p><strong>سعر الشراء الواحد:</strong> {{ $requestRecord->one_price_buy }}</p>
            <p><strong>رصيد متاح:</strong> {{ $requestRecord->rasid_motah }}</p>
            <p><strong>كود الفاتورة:</strong> {{ $requestRecord->fatora_code }}</p>
            <p><strong>تاريخ الفاتورة:</strong> {{ $requestRecord->fatora_date }}</p>
            <p><strong>تاريخ طباعة الفاتورة:</strong> {{ $requestRecord->fatora_print_date }}</p>
            <p><strong>الناشر:</strong> {{ $requestRecord->publisher }}</p>
            <p><strong>مرتجع:</strong> {{ $requestRecord->had_back }}</p>
            <p><strong>مبلغ المرتجع:</strong> {{ $requestRecord->had_back_amount }}</p>
            <p><strong>تاريخ المرتجع:</strong> {{ $requestRecord->had_back_date }}</p>
            <p><strong>التاريخ (عربي):</strong> {{ $requestRecord->date_ar }}</p>
            <p><strong>قديم:</strong> {{ $requestRecord->old ? 'نعم' : 'لا' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.requests.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
    <a href="{{ route('admin.requests.edit', $requestRecord->id) }}" class="btn btn-primary mt-3">تعديل</a>
@endsection
