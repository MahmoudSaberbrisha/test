@extends('admin.layouts.master')

@section('content')
    <h1 class="text-center mb-4">إضافة فاتورة مشتريات أخرى جديدة</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storepurchasesothers.store') }}" method="POST" class="p-4 border rounded shadow-sm">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="main_branch_id_fk" class="form-label">رقم الفرع الرئيسي</label>
                <select class="form-select form-control-3d" id="main_branch_id_fk" name="main_branch_id_fk" required>
                    <option value="">اختر الفرع الرئيسي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('main_branch_id_fk') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? $branch->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="sub_branch_id_fk" class="form-label">رقم الفرع الفرعي</label>
                <select class="form-select form-control-3d" id="sub_branch_id_fk" name="sub_branch_id_fk" required>
                    <option value="">اختر الفرع الفرعي</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('sub_branch_id_fk') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title ?? $branch->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="product_code" class="form-label">كود المنتج</label>
                <input type="text" class="form-control form-control-3d" id="product_code" name="product_code" required
                    value="{{ old('product_code') }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="product_name" class="form-label">اسم المنتج</label>
                <select class="form-select form-control-3d" id="product_name" name="product_name" required>
                    <option value="">اختر المنتج</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->name }}" data-product-code="{{ $product->sanf_code }}"
                            {{ old('product_name') == $product->name ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="amount_buy" class="form-label">كمية الشراء</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="amount_buy" name="amount_buy"
                    required value="{{ old('amount_buy') }}">
            </div>
            <div class="col-md-4">
                <label for="all_cost_buy" class="form-label">التكلفة الكلية للشراء</label>
                <input type="text" class="form-control form-control-3d" id="all_cost_buy" name="all_cost_buy" required
                    value="{{ old('all_cost_buy') }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="one_price_sell" class="form-label">سعر البيع الواحد</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="one_price_sell"
                    name="one_price_sell" required value="{{ old('one_price_sell') }}">
            </div>
            <div class="col-md-4">
                <label for="one_price_buy" class="form-label">سعر الشراء الواحد</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="one_price_buy"
                    name="one_price_buy" required value="{{ old('one_price_buy') }}">
            </div>
            <div class="col-md-4">
                <label for="rasid_motah" class="form-label">رصيد متاح</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="rasid_motah"
                    name="rasid_motah" required value="{{ old('rasid_motah') }}">
            </div>
            <div class="col-md-4">
                <label for="date_s" class="form-label">التاريخ (س)</label>
                <input type="date" class="form-control form-control-3d" id="date_s" name="date_s" required
                    value="{{ old('date_s') }}">
            </div>
            <div class="col-md-4">
                <label for="publisher" class="form-label">الناشر</label>
                <select class="form-select form-control-3d" id="publisher" name="publisher" required>
                    <option value="">اختر الناشر</option>
                    @foreach ($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ old('publisher') == $publisher->id ? 'selected' : '' }}>
                            {{ $publisher->name ?? ($publisher->email ?? $publisher->id) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="had_back" class="form-label">مرتجع</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="had_back"
                    name="had_back" required value="{{ old('had_back') }}">
            </div>
            <div class="col-md-4">
                <label for="had_back_amount" class="form-label">مبلغ المرتجع</label>
                <input type="number" step="0.01" class="form-control form-control-3d" id="had_back_amount"
                    name="had_back_amount" required value="{{ old('had_back_amount') }}">
            </div>
            <div class="col-md-4">
                <label for="fatora_code" class="form-label">كود الفاتورة</label>
                <input type="number" class="form-control form-control-3d" id="fatora_code" name="fatora_code" required
                    value="{{ old('fatora_code', $nextFatoraCode ?? '') }}">
            </div>
            <div class="col-md-4">
                <label for="fatora_date" class="form-label">تاريخ الفاتورة</label>
                <input type="date" class="form-control form-control-3d" id="fatora_date" name="fatora_date"
                    value="{{ old('fatora_date') }}">
            </div>
            <div class="col-md-4">
                <label for="fatora_print_date" class="form-label">تاريخ طباعة الفاتورة</label>
                <input type="date" class="form-control form-control-3d" id="fatora_print_date"
                    name="fatora_print_date" value="{{ old('fatora_print_date') }}">
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="supplier_code" class="form-label">كود المورد</label>
                <select class="form-select form-control-3d" id="supplier_code" name="supplier_code" required>
                    <option value="">اختر المورد</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->code }}"
                            {{ old('supplier_code') == $supplier->code ? 'selected' : '' }}>
                            {{ $supplier->name ?? $supplier->code }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="barcode" class="form-label">الباركود</label>
                <input type="text" class="form-control form-control-3d" id="barcode" name="barcode"
                    value="{{ old('barcode') }}">
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="had_back_date" class="form-label">تاريخ المرتجع</label>
                <input type="date" class="form-control form-control-3d" id="had_back_date" name="had_back_date"
                    value="{{ old('had_back_date') }}">
            </div>
            <div class="col-md-6">
                <label for="date_ar" class="form-label">التاريخ (عربي)</label>
                <input type="text" class="form-control form-control-3d" id="date_ar" name="date_ar"
                    value="{{ old('date_ar', '0') }}">
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="old" name="old" value="1"
                        {{ old('old') ? 'checked' : '' }}>
                    <label class="form-check-label" for="old">
                        قديم
                    </label>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <label for="box_name" class="form-label">اسم الخزنه</label>
                <select class="form-select form-control-3d" id="box_name" name="box_name" onchange="updateBoxId()">
                    <option value="">اختر اسم الصندوق</option>
                    @foreach ($boxes as $box)
                        <option value="{{ $box->id }}" data-box-id="{{ $box->id }}"
                            {{ old('box_name') == $box->id ? 'selected' : '' }}>
                            {{ $box->name ?? $box->id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="box_id_fk" class="form-label">رقم الخزنه</label>
                <input type="number" class="form-control form-control-3d" id="box_id_fk" name="box_id_fk"
                    value="{{ old('box_id_fk') }}" readonly>
            </div>
        </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const amountBuyInput = document.getElementById('amount_buy');
                    const onePriceBuyInput = document.getElementById('one_price_buy');
                    const allCostBuyInput = document.getElementById('all_cost_buy');
                    const productNameSelect = document.getElementById('product_name');
                    const productCodeInput = document.getElementById('product_code');
                    const boxNameSelect = document.getElementById('box_name');
                    const boxIdInput = document.getElementById('box_id_fk');
                    const rasidMotahInput = document.getElementById('rasid_motah');
                    const subBranchSelect = document.getElementById('sub_branch_id_fk');

                    // Use Laravel route helper to generate URL templates
                    const getBalanceUrlTemplate =
                        "{{ route('admin.storepurchasesothers.getBalance', ['box_id' => 'BOX_ID_PLACEHOLDER']) }}";
                    const getBoxesBySubBranchUrlTemplate =
                        "{{ route('admin.storekhazina.bySubBranch', ['subBranchId' => 'SUB_BRANCH_ID_PLACEHOLDER']) }}";

                    function calculateAllCostBuy() {
                        const amountBuy = parseFloat(amountBuyInput.value.replace(',', '.')) || 0;
                        const onePriceBuy = parseFloat(onePriceBuyInput.value.replace(',', '.')) || 0;
                        const allCostBuy = amountBuy * onePriceBuy;
                        allCostBuyInput.value = allCostBuy.toFixed(2);
                    }

                    function updateBoxId() {
                        var selectedOption = boxNameSelect.options[boxNameSelect.selectedIndex];
                        var boxId = selectedOption.getAttribute('data-box-id') || '';
                        boxIdInput.value = boxId;
                        if (boxId) {
                            const url = getBalanceUrlTemplate.replace('BOX_ID_PLACEHOLDER', boxId);
                            console.log('Fetching balance from URL:', url);
                            fetch(url, {
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.balance !== undefined) {
                                        rasidMotahInput.value = data.balance;
                                    } else {
                                        rasidMotahInput.value = '';
                                        alert('رصيد الخزنة غير موجود');
                                    }
                                })
                                .catch(error => {
                                    rasidMotahInput.value = '';
                                    console.error('Error fetching balance:', error);
                                    alert('حدث خطأ أثناء جلب رصيد الخزنة');
                                });
                        } else {
                            rasidMotahInput.value = '';
                        }
                    }

                    function updateBoxesBySubBranch(subBranchId) {
                        if (!subBranchId) {
                            boxNameSelect.innerHTML = '<option value="">اختر اسم الصندوق</option>';
                            boxIdInput.value = '';
                            rasidMotahInput.value = '';
                            return;
                        }
                        const url = getBoxesBySubBranchUrlTemplate.replace('SUB_BRANCH_ID_PLACEHOLDER', subBranchId);
                        console.log('Fetching boxes from URL:', url);
                        fetch(url, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                boxNameSelect.innerHTML = '<option value="">اختر اسم الصندوق</option>';
                                if (data.length > 0) {
                                    data.forEach(box => {
                                        const option = document.createElement('option');
                                        option.value = box.id;
                                        option.textContent = box.name;
                                        option.setAttribute('data-box-id', box.id);
                                        boxNameSelect.appendChild(option);
                                    });
                                    // Select first box and update box id and balance
                                    boxNameSelect.selectedIndex = 1;
                                    updateBoxId();
                                } else {
                                    boxIdInput.value = '';
                                    rasidMotahInput.value = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching boxes:', error);
                                boxNameSelect.innerHTML = '<option value="">اختر اسم الصندوق</option>';
                                boxIdInput.value = '';
                                rasidMotahInput.value = '';
                            });
                    }

                    function updateProductCode() {
                        var selectedOption = productNameSelect.options[productNameSelect.selectedIndex];
                        var productCode = selectedOption.getAttribute('data-product-code') || '';
                        productCodeInput.value = productCode;
                    }

                    amountBuyInput.addEventListener('input', calculateAllCostBuy);
                    onePriceBuyInput.addEventListener('input', calculateAllCostBuy);
                    productNameSelect.addEventListener('change', updateProductCode);
                    boxNameSelect.addEventListener('change', updateBoxId);
                    subBranchSelect.addEventListener('change', function() {
                        updateBoxesBySubBranch(this.value);
                    });

                    // Initialize on page load
                    calculateAllCostBuy();
                    updateBoxId();
                    updateProductCode();
                    updateBoxesBySubBranch(subBranchSelect.value);
                });
            </script>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary">إضافة فاتورة مشتريات أخرى</button>
            <a href="{{ route('admin.storepurchasesothers.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
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
