@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>جدول مخزون المتجر</h1>
        <a href="{{ route('admin.storeinventorytable.create') }}" class="btn btn-primary">إضافة سجل مخزون جديد</a>
    </div>

    <div class="row">
        @foreach ($inventories as $inventory)
            @php
                $item = $items->firstWhere('id', $inventory->item_id_fk);
                $employee = $employees->firstWhere('id', $inventory->employee_id_fk);
                $user = $users->firstWhere('id', $inventory->user_id);
            @endphp
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <strong>{{ $item ? $item->name : 'غير متوفر' }}</strong>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>المعرف:</strong> {{ $inventory->id }}</div>
                            <div class="col-6"><strong>كود العنصر:</strong> {{ $item ? $item->sanf_code : 'غير متوفر' }}
                            </div>
                            <div class="col-6"><strong>معرف التخزين:</strong> {{ $inventory->storage_id_fk }}</div>
                            <div class="col-6"><strong>الكمية:</strong> {{ $inventory->amount }}</div>
                            <div class="col-6"><strong>عدد الجرد:</strong> {{ $inventory->num_invent }}</div>
                            <div class="col-6"><strong>الكمية المتوفرة:</strong> {{ $inventory->available_amount }}</div>
                            <div class="col-6"><strong>تاريخ الجرد:</strong> {{ $inventory->invent_date }}</div>
                            <div class="col-6"><strong>نوع الصنف:</strong> {{ $inventory->sanf_type_gym ? 'نعم' : 'لا' }}
                            </div>
                            <div class="col-6"><strong>الموظف:</strong>
                                {{ $employee ? $employee->name ?? $employee->id : 'غير متوفر' }}</div>
                            <div class="col-6"><strong>التاريخ:</strong> {{ $inventory->date }}</div>
                            <div class="col-6"><strong>التاريخ (S):</strong> {{ $inventory->date_s }}</div>
                            <div class="col-6"><strong>التاريخ (AR):</strong> {{ $inventory->date_ar }}</div>
                            <div class="col-6"><strong>الناشر:</strong> {{ $inventory->publisher }}</div>
                            <div class="col-6"><strong>معرف الفرع الفرعي:</strong> {{ $inventory->sub_branch_id_fk }}
                            </div>
                            <div class="col-6"><strong>كود الموظف:</strong> {{ $inventory->emp_code }}</div>
                            <div class="col-6"><strong>المستخدم:</strong>
                                {{ $user ? $user->name ?? $user->id : 'غير متوفر' }}</div>
                            <div class="col-6"><strong>كمية العجز:</strong> {{ $inventory->deficit_amount }}</div>
                            <div class="col-6"><strong>كمية الزيادة:</strong> {{ $inventory->increase_amount }}</div>
                            <div class="col-12"><strong>ملاحظات:</strong> {{ $inventory->notes }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storeinventorytable.show', $inventory->id) }}"
                            class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('admin.storeinventorytable.edit', $inventory->id) }}"
                            class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.storeinventorytable.destroy', $inventory->id) }}" method="POST"
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
