@extends('admin.layouts.master')

@section('content')
    <h1>تفاصيل عنصر المخزن</h1>

    <div class="card" style="color: black;">
        <div class="card-body">
            <p><strong>اسم العنصر:</strong> {{ $item->name }}</p>
            <p><strong>كود العنصر:</strong> {{ $item->sanf_code }}</p>
            <p><strong>نوع العنصر:</strong> {{ $item->sanf_type }}</p>
            <p><strong>الوحدة:</strong> {{ $item->unit }}</p>
            <p><strong>سعر البيع:</strong> {{ $item->sale_price }}</p>
            <p><strong>الفرع الرئيسي:</strong> {{ $item->mainBranch->title ?? 'غير معروف' }}</p>
            <p><strong>الفرع الفرعي:</strong> {{ $item->subBranch->title ?? 'غير معروف' }}</p>
            <p><strong>حد الطلب:</strong> {{ $item->limit_order }}</p>
            <p><strong>الحد الأدنى:</strong> {{ $item->min_limit }}</p>
            <p><strong>إجمالي تكلفة الشراء:</strong> {{ $item->all_buy_cost }}</p>
            <p><strong>إجمالي الكمية:</strong> {{ $item->all_amount }}</p>
            <p><strong>تكلفة شراء واحدة:</strong> {{ $item->one_buy_cost }}</p>
            <p><strong>رصيد الفترة الأولى:</strong> {{ $item->first_balance_period }}</p>
            <p><strong>الكمية السابقة:</strong> {{ $item->past_amount }}</p>
            <p><strong>تكلفة الكمية السابقة:</strong> {{ $item->cost_past_amount }}</p>
            <a href="{{ route('admin.storeitems.edit', $item->id) }}" class="btn btn-primary mt-3">تعديل</a>
            <a href="{{ route('admin.storeitems.index') }}" class="btn btn-secondary mt-3">عودة إلى القائمة</a>
        </div>
    </div>
@endsection
