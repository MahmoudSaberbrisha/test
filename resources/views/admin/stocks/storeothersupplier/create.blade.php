@extends('admin.layouts.master')

@section('content')
    <h1>إضافة مورد آخر جديد</h1>

    <form action="{{ route('admin.storeothersupplier.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="code" class="form-label">الكود</label>
                <input type="text" class="form-control form-control-3d @error('code') is-invalid @enderror" id="code"
                    name="code" required value="{{ old('code', $nextCode ?? '') }}">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">اسم المورد</label>
                <input type="text" class="form-control form-control-3d @error('name') is-invalid @enderror"
                    id="name" name="name" required maxlength="255" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="supplier_address" class="form-label">عنوان المورد</label>
                <textarea class="form-control form-control-3d @error('supplier_address') is-invalid @enderror" id="supplier_address"
                    name="supplier_address" rows="3">{{ old('supplier_address') }}</textarea>
                @error('supplier_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="supplier_phone" class="form-label">هاتف المورد</label>
                <input type="text" class="form-control form-control-3d @error('supplier_phone') is-invalid @enderror"
                    id="supplier_phone" name="supplier_phone" maxlength="50" value="{{ old('supplier_phone') }}">
                @error('supplier_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="supplier_fax" class="form-label">فاكس المورد</label>
                <input type="text" class="form-control form-control-3d @error('supplier_fax') is-invalid @enderror"
                    id="supplier_fax" name="supplier_fax" maxlength="50" value="{{ old('supplier_fax') }}">
                @error('supplier_fax')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="accountant_name" class="form-label">اسم المحاسب</label>
                <select class="form-select form-control-3d @error('accountant_name') is-invalid @enderror"
                    id="accountant_name" name="accountant_name">
                    <option value="">اختر المحاسب</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->name }}"
                            {{ old('accountant_name') == $employee->name ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('accountant_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="accountant_telephone" class="form-label">هاتف المحاسب</label>
                <input type="text"
                    class="form-control form-control-3d @error('accountant_telephone') is-invalid @enderror"
                    id="accountant_telephone" name="accountant_telephone" maxlength="50"
                    value="{{ old('accountant_telephone') }}">
                @error('accountant_telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="supplier_dayen" class="form-label">ديون المورد</label>
                <input type="number" step="any"
                    class="form-control form-control-3d @error('supplier_dayen') is-invalid @enderror" id="supplier_dayen"
                    name="supplier_dayen" value="{{ old('supplier_dayen') }}">
                @error('supplier_dayen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">إضافة المورد</button>
            <a href="{{ route('admin.storeothersupplier.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');

            codeInput.addEventListener('input', function() {
                const code = codeInput.value.trim();

                console.log('Input event triggered. Checking code:', code);

                if (code === '') {
                    return;
                }

                fetch(`{{ route('admin.storeothersupplier.nextCode') }}?code=${encodeURIComponent(code)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response from nextCode API:', data);
                        if (data.nextCode && data.nextCode !== code && data.nextCode > code) {
                            alert('Code updated to: ' + data.nextCode);
                            codeInput.value = data.nextCode;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next code:', error);
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
