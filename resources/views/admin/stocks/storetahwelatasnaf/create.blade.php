@extends('admin.layouts.master')

@section('content')
    <h1>Add New Tahwelat Asnaf</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storetahwelatasnaf.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rkm_fk" class="form-label">Rkm FK</label>
            <input type="number" class="form-control" id="rkm_fk" name="rkm_fk" required value="{{ old('rkm_fk') }}">
        </div>
        <div class="mb-3">
            <label for="sanf_id" class="form-label">Sanf ID</label>
            <input type="number" class="form-control" id="sanf_id" name="sanf_id" required value="{{ old('sanf_id') }}">
        </div>
        <div class="mb-3">
            <label for="sanf_n" class="form-label">Sanf Name</label>
            <input type="text" class="form-control" id="sanf_n" name="sanf_n" required maxlength="255"
                value="{{ old('sanf_n') }}">
        </div>
        <div class="mb-3">
            <label for="sanf_code" class="form-label">Sanf Code</label>
            <input type="number" class="form-control" id="sanf_code" name="sanf_code" required
                value="{{ old('sanf_code') }}">
        </div>
        <div class="mb-3">
            <label for="amount_motah" class="form-label">Amount Motah</label>
            <input type="number" class="form-control" id="amount_motah" name="amount_motah" required
                value="{{ old('amount_motah') }}">
        </div>
        <div class="mb-3">
            <label for="amount_send" class="form-label">Amount Send</label>
            <input type="number" class="form-control" id="amount_send" name="amount_send" required
                value="{{ old('amount_send') }}">
        </div>
        <div class="mb-3">
            <label for="from_storage" class="form-label">From Storage</label>
            <input type="number" class="form-control" id="from_storage" name="from_storage" required
                value="{{ old('from_storage') }}">
        </div>
        <div class="mb-3">
            <label for="to_storage" class="form-label">To Storage</label>
            <input type="number" class="form-control" id="to_storage" name="to_storage" required
                value="{{ old('to_storage') }}">
        </div>
        <button type="submit" class="btn btn-primary">Add Tahwelat Asnaf</button>
        <a href="{{ route('admin.storetahwelatasnaf.index') }}" class="btn btn-secondary">Cancel</a>
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
