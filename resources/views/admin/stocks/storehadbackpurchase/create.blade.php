@extends('admin.layouts.master')

@section('content')
    <h1>إضافة عملية شراء مرتجعة جديدة</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storehadbackpurchase.store') }}" method="POST" style="color: white;">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="main_branch_id_fk" class="form-label">رقم الفرع الرئيسي</label>
                <select class="form-select form-control-3d" id="main_branch_id_fk" name="main_branch_id_fk" required
                    style="color: black;">
                    <option value="">اختر الفرع الرئيسي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('main_branch_id_fk') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? $branch->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sub_branch_id_fk" class="form-label">رقم الفرع الفرعي</label>
                <select class="form-select form-control-3d" id="sub_branch_id_fk" name="sub_branch_id_fk" required
                    style="color: black;">
                    <option value="">اختر الفرع الفرعي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('sub_branch_id_fk') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? $branch->id }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="supplier_code" class="form-label">كود المورد</label>
                <select class="form-select form-control-3d" id="supplier_code" name="supplier_code" required
                    style="color: black;">
                    <option value="">اختر المورد</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->code }}"
                            {{ old('supplier_code') == $supplier->code ? 'selected' : '' }}>
                            {{ $supplier->name ?? $supplier->code }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fatora_code" class="form-label">كود الفاتورة</label>
                <select class="form-select form-control-3d" id="fatora_code" name="fatora_code" required
                    style="color: black;">
                    <option value="">اختر كود الفاتورة</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->fatora_code }}" data-amount-buy="{{ $invoice->amount_buy }}"
                            data-product-name="{{ $invoice->product_name }}"
                            data-all-cost-buy="{{ $invoice->all_cost_buy }}"
                            data-product-code="{{ $invoice->product_code }}"
                            data-one-price-sell="{{ $invoice->one_price_buy }}"
                            {{ old('fatora_code') == $invoice->fatora_code ? 'selected' : '' }}>
                            {{ $invoice->fatora_code }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="product_name" class="form-label">اسم المنتج</label>
                <input type="text" class="form-control form-control-3d" id="product_name" name="product_name" readonly
                    value="{{ old('product_name') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="product_code" class="form-label">كود المنتج</label>
                <input type="text" class="form-control form-control-3d" id="product_code" name="product_code" required
                    value="{{ old('product_code') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="amount_buy" class="form-label">كمية الشراء</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="amount_buy" name="amount_buy"
                    required value="{{ old('amount_buy') }}" style="color: black;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="all_cost_buy" class="form-label">إجمالي تكلفة الشراء</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="all_cost_buy"
                    name="all_cost_buy" required value="{{ old('all_cost_buy') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="one_price_sell" class="form-label">سعر الشراء للوحدة</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="one_price_sell"
                    name="one_price_sell" required value="{{ old('one_price_sell') }}" style="color: black;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="hadback_amount" class="form-label">كمية المرتجع</label>
                <input type="number" class="form-control form-control-3d" id="hadback_amount" name="hadback_amount"
                    required value="{{ old('hadback_amount') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">التاريخ </label>
                <input type="date" class="form-control form-control-3d" id="date" name="date" required
                    value="{{ old('date') }}" style="color: black;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date_s" class="form-label">التاريخ S</label>
                <input type="date" class="form-control form-control-3d" id="date_s" name="date_s" required
                    value="{{ old('date_s') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="publisher" class="form-label">رقم الناشر</label>
                <select class="form-select form-control-3d" id="publisher" name="publisher" required
                    style="color: black;">
                    <option value="">اختر الناشر</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('publisher') == $user->id ? 'selected' : '' }}>
                            {{ $user->name ?? $user->id }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">إضافة عملية شراء مرتجعة</button>
        <a href="{{ route('admin.storehadbackpurchase.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fatoraSelect = document.getElementById('fatora_code');
            const amountBuyInput = document.getElementById('amount_buy');
            const allCostBuyInput = document.getElementById('all_cost_buy');
            const productNameInput = document.getElementById('product_name');
            const productCodeInput = document.getElementById('product_code');
            const onepPriceSellInput = document.getElementById('one_price_sell');

            fatoraSelect.addEventListener('change', function() {
                const selectedOption = fatoraSelect.options[fatoraSelect.selectedIndex];
                const amountBuy = selectedOption.getAttribute('data-amount-buy');
                const allCostBuy = selectedOption.getAttribute('data-all-cost-buy');
                const productName = selectedOption.getAttribute('data-product-name');
                const productCode = selectedOption.getAttribute('data-product-code');
                const onePriceSell = selectedOption.getAttribute('data-one-price-sell');

                if (amountBuy) {
                    amountBuyInput.value = amountBuy;
                } else {
                    amountBuyInput.value = '';
                }

                if (productName) {
                    productNameInput.value = productName;
                } else {
                    productNameInput.value = '';
                }
                if (productCode) {
                    productCodeInput.value = productCode;
                } else {
                    productCodeInput.value = '';
                }

                if (allCostBuy) {
                    allCostBuyInput.value = allCostBuy;
                } else {
                    allCostBuyInput.value = '';
                }
                if (onePriceSell) {
                    onepPriceSellInput.value = onePriceSell;
                } else {
                    onepPriceSellInput.value = '';
                }

                // For product_code, if you have a way to get it, you can set it here.
                // Currently, product_code is not available in the invoice options.
                // You may need to fetch it via AJAX or add it as a data attribute if available.
            });
        });
    </script>
    <style>
        .form-control-3d {
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            box-shadow: none;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            color: #2c3e50;
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
        }

        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2c3e50;
        }
    </style>
@endsection
