@extends('admin.layouts.master')

@section('content')
    <h1>تعديل سجل جرد</h1>

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

    <form action="{{ route('admin.storeinventorytable.update', $inventory->id) }}" method="POST" style="color: white;">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="item_id_fk" class="form-label">العنصر</label>
                <select class="form-select form-control-3d" id="item_id_fk" name="item_id_fk" required>
                    <option value="">اختر العنصر</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-amount="{{ $item->all_amount }}"
                            data-category="{{ $item->category_name }}"
                            {{ old('item_id_fk', $inventory->item_id_fk) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="category" class="form-label">الفئة</label>
                <input type="text" class="form-control form-control-3d" id="category" name="category" readonly
                    value="{{ old('category', $inventory->category) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="storage_id_fk" class="form-label">معرف التخزين</label>
                <select class="form-select form-control-3d" id="storage_id_fk" name="storage_id_fk" required>
                    <option value="">اختر الفرع</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->br_code }}"
                            {{ old('storage_id_fk', $inventory->storage_id_fk) == $branch->br_code ? 'selected' : '' }}>
                            {{ $branch->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">الكمية</label>
                <input type="number" class="form-control form-control-3d" id="amount" name="amount" required
                    value="{{ old('amount', $inventory->amount) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="num_invent" class="form-label">رقم الجرد</label>
                <input type="text" class="form-control form-control-3d" id="num_invent" name="num_invent" required
                    readonly value="{{ old('num_invent', $inventory->num_invent) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="available_amount" class="form-label">الكمية المتوفرة</label>
                <input type="text" class="form-control form-control-3d" id="available_amount" name="available_amount"
                    required maxlength="50" value="{{ old('available_amount', $inventory->available_amount) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="invent_date" class="form-label">تاريخ الجرد</label>
                <input type="text" class="form-control form-control-3d" id="invent_date" name="invent_date" required
                    maxlength="50" readonly value="{{ old('invent_date', $inventory->invent_date) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">التاريخ</label>
                <input type="text" class="form-control form-control-3d" id="date" name="date" required
                    maxlength="50" readonly value="{{ old('date', $inventory->date) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_s" class="form-label">التاريخ (S)</label>
                <input type="text" class="form-control form-control-3d" id="date_s" name="date_s" required
                    maxlength="50" readonly value="{{ old('date_s', $inventory->date_s) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date_ar" class="form-label">التاريخ (AR)</label>
                <input type="text" class="form-control form-control-3d" id="date_ar" name="date_ar" required
                    maxlength="50" readonly value="{{ old('date_ar', $inventory->date_ar) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label d-block">الناشر</label>
                <input type="hidden" id="publisher" name="publisher"
                    value="{{ old('publisher', $inventory->publisher) }}">
                <ul class="list-group" id="publisher-list" style="max-height: 200px; overflow-y: auto;">
                    @foreach ($users as $user)
                        <li class="list-group-item list-group-item-action {{ old('publisher', $inventory->publisher) == $user->id ? 'active' : '' }}"
                            data-id="{{ $user->id }}" style="cursor: pointer;">
                            {{ $user->name ?? $user->id }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sub_branch_id_fk" class="form-label">الفرع الفرعي</label>
                <select class="form-select form-control-3d" id="sub_branch_id_fk" name="sub_branch_id_fk" required>
                    <option value="">اختر الفرع</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->br_code }}"
                            {{ old('sub_branch_id_fk', $inventory->sub_branch_id_fk) == $branch->br_code ? 'selected' : '' }}>
                            {{ $branch->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="deficit_amount" class="form-label">مقدار العجز</label>
                <input type="number" class="form-control form-control-3d" id="deficit_amount" name="deficit_amount"
                    required value="{{ old('deficit_amount', $inventory->deficit_amount) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="increase_amount" class="form-label">مقدار الزيادة</label>
                <input type="number" class="form-control form-control-3d" id="increase_amount" name="increase_amount"
                    required value="{{ old('increase_amount', $inventory->increase_amount) }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">تحديث الجرد</button>
        <a href="{{ route('admin.storeinventorytable.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('item_id_fk');
            const amountInput = document.getElementById('amount');
            const categoryInput = document.getElementById('category');

            function updateAmountAndCategory() {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const amount = selectedOption.getAttribute('data-amount') || '';
                const category = selectedOption.getAttribute('data-category') || '';
                amountInput.value = amount;
                categoryInput.value = category;
            }

            itemSelect.addEventListener('change', updateAmountAndCategory);

            // Initialize amount and category on page load if an item is already selected
            updateAmountAndCategory();

            const publisherList = document.getElementById('publisher-list');
            const publisherInput = document.getElementById('publisher');

            publisherList.querySelectorAll('li').forEach(function(item) {
                item.addEventListener('click', function() {
                    publisherList.querySelectorAll('li').forEach(li => li.classList.remove(
                        'active'));
                    this.classList.add('active');
                    publisherInput.value = this.getAttribute('data-id');
                });
            });
        });
    </script>

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
