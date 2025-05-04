@extends('admin.layouts.master')

@section('content')
    <h1>تعديل إعداد التصنيف</h1>

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

    <form action="{{ route('admin.storetasnefsetting.update', $setting->id) }}" method="POST" style="color: white;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control form-control-3d" id="name" name="name" required maxlength="255"
                value="{{ old('name', $setting->name) }}">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control form-control-3d" id="type" name="type" maxlength="255"
                value="{{ old('type', $setting->type) }}">
        </div>
        <button type="submit" class="btn btn-primary">تحديث إعداد التصنيف</button>
        <a href="{{ route('admin.storetasnefsetting.index') }}" class="btn btn-secondary">إلغاء</a>
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
