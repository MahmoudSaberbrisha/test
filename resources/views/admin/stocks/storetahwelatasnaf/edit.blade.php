@extends('admin.layouts.master')

@section('content')
    <h1>تعديل تحويل صنف</h1>

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

    <form action="{{ route('admin.storetahwelatasnaf.update', $record->id) }}" method="POST" style="color: white;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="rkm_fk" class="form-label">Rkm FK</label>
            <input type="number" class="form-control form-control-3d" id="rkm_fk" name="rkm_fk" required
                value="{{ old('rkm_fk', $record->rkm_fk) }}">
        </div>
        <div class="mb-3">
            <label for="sanf_id" class="form-label">Sanf ID</label>
            <input type="number" class="form-control form-control-3d" id="sanf_id" name="sanf_id" required
                value="{{ old('sanf_id', $record->sanf_id) }}">
        </div>
        <div class="mb-3">
            <label for="sanf_n" class="form-label">Sanf Name</label>
            <input type="text" class="form-control form-control-3d" id="sanf_n" name="sanf_n" required
                maxlength="255" value="{{ old('sanf_n', $record->sanf_n) }}">
        </div>
        <div class="mb-3">
            <label for="sanf_code" class="form-label">Sanf Code</label>
            <input type="number" class="form-control form-control-3d" id="sanf_code" name="sanf_code" required
                value="{{ old('sanf_code', $record->sanf_code) }}">
        </div>
        <div class="mb-3">
            <label for="amount_motah" class="form-label">Amount Motah</label>
            <input type="number" class="form-control form-control-3d" id="amount_motah" name="amount_motah" required
                value="{{ old('amount_motah', $record->amount_motah) }}">
        </div>
        <div class="mb-3">
            <label for="amount_send" class="form-label">Amount Send</label>
            <input type="number" class="form-control form-control-3d" id="amount_send" name="amount_send" required
                value="{{ old('amount_send', $record->amount_send) }}">
        </div>
        <div class="mb-3">
            <label for="from_storage" class="form-label">From Storage</label>
            <input type="number" class="form-control form-control-3d" id="from_storage" name="from_storage" required
                value="{{ old('from_storage', $record->from_storage) }}">
        </div>
        <div class="mb-3">
            <label for="to_storage" class="form-label">To Storage</label>
            <input type="number" class="form-control form-control-3d" id="to_storage" name="to_storage" required
                value="{{ old('to_storage', $record->to_storage) }}">
        </div>
        <button type="submit" class="btn btn-primary">تحديث تحويل صنف</button>
        <a href="{{ route('admin.storetahwelatasnaf.index') }}" class="btn btn-secondary">إلغاء</a>
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
