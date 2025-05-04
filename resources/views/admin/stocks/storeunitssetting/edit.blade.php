@extends('admin.layouts.master')

@section('content')
    <h1>تعديل إعداد الوحدة</h1>

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

    <form action="{{ route('admin.storeunitssetting.update', $setting->id) }}" method="POST" style="color: white;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="unit_name" class="form-label">Unit Name</label>
            <input type="text" class="form-control form-control-3d" id="unit_name" name="unit_name" required maxlength="100"
                value="{{ old('unit_name', $setting->unit_name) }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control form-control-3d" id="description" name="description">{{ old('description', $setting->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">تحديث إعداد الوحدة</button>
        <a href="{{ route('admin.storeunitssetting.index') }}" class="btn btn-secondary">إلغاء</a>
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

        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
        }
    </style>
@endsection
