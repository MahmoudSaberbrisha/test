@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>طلبات المخزن</h1>
        <a href="{{ route('admin.requests.create') }}" class="btn btn-primary">إضافة طلب جديد</a>
    </div>

    <div class="row">
        @foreach ($requests as $request)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.requests.show', $request->id) }}" class="text-white text-decoration-none">
                            {{ $request->main_branch_id_fk }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $request->id }}</div>
                            <div class="col-6"><strong>معرف الفرع الرئيسي:</strong> {{ $request->main_branch_id_fk }}</div>
                            <div class="col-6"><strong>معرف الفرع الفرعي:</strong> {{ $request->sub_branch_id_fk }}</div>
                            <div class="col-6"><strong>كود المنتج:</strong> {{ $request->product_code }}</div>
                            <div class="col-6"><strong>اسم المنتج:</strong> {{ $request->product_name }}</div>
                            <div class="col-6"><strong>كمية الشراء:</strong> {{ $request->amount_buy }}</div>
                            <div class="col-6"><strong>التكلفة الكلية للشراء:</strong> {{ $request->all_cost_buy }}</div>
                            <div class="col-6"><strong>سعر البيع الواحد:</strong> {{ $request->one_price_sell }}</div>
                            <div class="col-6"><strong>سعر الشراء الواحد:</strong> {{ $request->one_price_buy }}</div>
                            <div class="col-6"><strong>رصيد متاح:</strong> {{ $request->rasid_motah }}</div>
                            <div class="col-6"><strong>كود الفاتورة:</strong> {{ $request->fatora_code }}</div>
                            <div class="col-6"><strong>تاريخ الفاتورة:</strong> {{ $request->date_s }}</div>
                            <div class="col-6"><strong>التاريخ (عربي):</strong> {{ $request->date_ar }}</div>
                            <div class="col-6"><strong>الناشر:</strong> {{ $request->publisher }}</div>
                            <div class="col-6"><strong>مرتجع:</strong> {{ $request->had_back }}</div>
                            <div class="col-6"><strong>تاريخ المرتجع:</strong> {{ $request->had_back_date }}</div>
                            <div class="col-6"><strong>مبلغ المرتجع:</strong> {{ $request->had_back_amount }}</div>
                            <div class="col-6"><strong>قديم:</strong> {{ $request->old ? 'نعم' : 'لا' }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.requests.edit', $request->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('هل أنت متأكد؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                        @if (!$request->approved)
                            <form action="{{ route('admin.requests.approve', $request->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا العنصر؟');">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-success" type="submit">موافقة</button>
                            </form>
                        @else
                            <span class="badge bg-success">تمت الموافقة</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
