@extends('admin.layouts.master')

@section('content')
    <h1>تعديل عنصر المخزن</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @if ($errors->has('error'))
                    <li>{{ $errors->first('error') }}</li>
                @endif
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storeitems.update', $item->id) }}" method="POST" style="color: white;">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">اسم العنصر</label>
                <input type="text" class="form-control form-control-3d" id="name" name="name" required
                    maxlength="50" value="{{ old('name', $item->name) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sanf_code" class="form-label">كود العنصر</label>
                <input type="text" class="form-control form-control-3d" id="sanf_code" name="sanf_code" required
                    maxlength="50" value="{{ old('sanf_code', $item->sanf_code) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="main_branch_id_fk" class="form-label">الفرع الرئيسي</label>
                <select class="form-select form-control-3d" id="main_branch_id_fk" name="main_branch_id_fk" required>
                    <option value="">اختر الفرع الرئيسي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old('main_branch_id_fk', $item->main_branch_id_fk) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? 'فرع بدون اسم' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sub_branch_id_fk" class="form-label">الفرع الفرعي</label>
                <select class="form-select form-control-3d" id="sub_branch_id_fk" name="sub_branch_id_fk" required>
                    <option value="">اختر الفرع الفرعي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"
                            {{ old('sub_branch_id_fk', $item->sub_branch_id_fk) == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? 'فرع بدون اسم' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="category" class="form-label">الفئة</label>
                <select class="form-select form-control-3d" id="category" name="category" required>
                    <option value="">اختر الفئة</option>
                    <option value="1" {{ old('category', $item->category) == 1 ? 'selected' : '' }}>وحدات</option>
                    <option value="2" {{ old('category', $item->category) == 2 ? 'selected' : '' }}>كراتين</option>
                    <option value="3" {{ old('category', $item->category) == 3 ? 'selected' : '' }}>علب</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="unit" class="form-label">الوحدة</label>
                <input type="text" class="form-control form-control-3d" id="unit" name="unit" required
                    maxlength="50" value="{{ old('unit', $item->unit) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="limit_order" class="form-label">حد الطلب</label>
                <input type="text" class="form-control form-control-3d" id="limit_order" name="limit_order"
                    maxlength="50" value="{{ old('limit_order', $item->limit_order) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="min_limit" class="form-label">الحد الأدنى</label>
                <input type="text" class="form-control form-control-3d" id="min_limit" name="min_limit" maxlength="50"
                    value="{{ old('min_limit', $item->min_limit) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="all_buy_cost" class="form-label">إجمالي تكلفة الشراء</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="all_buy_cost"
                    name="all_buy_cost" value="{{ old('all_buy_cost', $item->all_buy_cost) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="all_amount" class="form-label">إجمالي الكمية</label>
                <input type="text" class="form-control form-control-3d" id="all_amount" name="all_amount" maxlength="50"
                    value="{{ old('all_amount', $item->all_amount) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="one_buy_cost" class="form-label">تكلفة شراء واحدة</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="one_buy_cost"
                    name="one_buy_cost" value="{{ old('one_buy_cost', $item->one_buy_cost) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="customer_price_sale" class="form-label">سعر البيع للعميل</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="customer_price_sale"
                    name="customer_price_sale" value="{{ old('customer_price_sale', $item->customer_price_sale) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_balance_period" class="form-label">رصيد الفترة الأولى</label>
                <input type="text" class="form-control form-control-3d" id="first_balance_period"
                    name="first_balance_period" maxlength="50"
                    value="{{ old('first_balance_period', $item->first_balance_period) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="past_amount" class="form-label">الكمية السابقة</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="past_amount"
                    name="past_amount" value="{{ old('past_amount', $item->past_amount) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cost_past_amount" class="form-label">تكلفة الكمية السابقة</label>
                <input type="text" class="form-control form-control-3d" id="cost_past_amount" name="cost_past_amount"
                    maxlength="50" value="{{ old('cost_past_amount', $item->cost_past_amount) }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sale_price" class="form-label">سعر البيع</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="sale_price"
                    name="sale_price" value="{{ old('sale_price', $item->sale_price) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">تحديث العنصر</button>
        <a href="{{ route('admin.storeitems.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>

    <style>
        form {
            color: white;
        }

        .form-control-3d {
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            box-shadow: none;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            color: black;
            background-color: #eaf2f8;
        }

        .form-control-3d:focus {
            box-shadow: 0 0 8px 2px #3498db;
            border-color: #2980b9;
            background-color: #ffffff;
            outline: none;
        }

        .form-select.form-control-3d {
            padding-right: 2rem;
            padding-left: 0.75rem;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%233498db' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 8px 10px;
            width: 100%;
            box-sizing: border-box;
            color: black;
        }

        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
        }
    </style>
@endsection
