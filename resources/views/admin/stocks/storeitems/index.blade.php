@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>عناصر المتجر</h1>
        <a href="{{ route('admin.storeitems.create') }}" class="btn btn-primary">إضافة عنصر جديد</a>
    </div>

    <div class="row">
        @foreach ($items as $item)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storeitems.show', $item->id) }}" class="text-white text-decoration-none">
                            {{ $item->name }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $item->id }}</div>
                            <div class="col-6"><strong>الكود:</strong> {{ $item->sanf_code }}</div>
                            <div class="col-6"><strong>النوع:</strong> {{ $item->category_name }}</div>
                            <div class="col-6"><strong>الفرع الرئيسي:</strong>
                                {{ $item->mainBranch->title ?? 'غير معروف' }}</div>
                            <div class="col-6"><strong>الفرع الفرعي:</strong> {{ $item->subBranch->title ?? 'غير معروف' }}
                            </div>
                            <div class="col-6"><strong>الوحدة:</strong> {{ $item->unit }}</div>
                            <div class="col-6"><strong>حد الطلب:</strong> {{ $item->limit_order }}</div>
                            <div class="col-6"><strong>الحد الأدنى:</strong> {{ $item->min_limit }}</div>
                            <div class="col-6"><strong>تكلفة الشراء الكلية:</strong> {{ $item->all_buy_cost }}</div>
                            <div class="col-6"><strong>الكمية الكلية:</strong> {{ $item->all_amount }}</div>
                            <div class="col-6"><strong>تكلفة الشراء الواحدة:</strong> {{ $item->one_buy_cost }}</div>
                            <div class="col-6"><strong>سعر البيع للعميل:</strong> {{ $item->customer_price_sale }}</div>
                            <div class="col-6"><strong>رصيد الفترة الأولى:</strong> {{ $item->first_balance_period }}
                            </div>
                            <div class="col-6"><strong>الكمية السابقة:</strong> {{ $item->past_amount }}</div>
                            <div class="col-6"><strong>تكلفة الكمية السابقة:</strong> {{ $item->cost_past_amount }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storeitems.edit', $item->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storeitems.destroy', $item->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('هل أنت متأكد؟');">
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
