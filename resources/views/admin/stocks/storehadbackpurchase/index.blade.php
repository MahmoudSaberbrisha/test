@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>مشتريات المرتجعات للمخزن</h1>
        <a href="{{ route('admin.storehadbackpurchase.create') }}" class="btn btn-primary">إضافة مرتجع جديد</a>
    </div>

    <div class="row">
        @foreach ($hadbacks as $hadback)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <strong>فاتورة: {{ $hadback->fatora_code }}</strong>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $hadback->id }}</div>
                            <div class="col-6"><strong>الفرع الرئيسي:</strong>
                                {{ $hadback->mainBranch ? $hadback->mainBranch->title ?? '' : '' }}</div>
                            <div class="col-6"><strong>الفرع الفرعي:</strong>
                                {{ $hadback->subBranch ? $hadback->subBranch->title ?? '' : '' }}</div>
                            <div class="col-6"><strong>المورد:</strong>
                                {{ $hadback->supplier ? $hadback->supplier->name ?? '' : '' }}</div>
                            <div class="col-6"><strong>كود المنتج:</strong> {{ $hadback->product_code }}</div>
                            <div class="col-6"><strong>كمية الشراء:</strong> {{ $hadback->amount_buy }}</div>
                            <div class="col-6"><strong>إجمالي تكلفة الشراء:</strong> {{ $hadback->all_cost_buy }}</div>
                            <div class="col-6"><strong>سعر الشراء للوحدة:</strong> {{ $hadback->one_price_sell }}</div>
                            <div class="col-6"><strong>كمية المرتجع:</strong> {{ $hadback->hadback_amount }}</div>
                            <div class="col-6"><strong>التاريخ:</strong> {{ date('Y-m-d', $hadback->date) }}</div>
                            <div class="col-6"><strong>الناشر:</strong>
                                {{ $hadback->publisherUser ? $hadback->publisherUser->name ?? '' : '' }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storehadbackpurchase.show', $hadback->id) }}"
                            class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('admin.storehadbackpurchase.edit', $hadback->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storehadbackpurchase.destroy', $hadback->id) }}" method="POST"
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
