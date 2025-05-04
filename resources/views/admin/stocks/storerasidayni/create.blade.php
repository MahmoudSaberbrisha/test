@extends('admin.layouts.master')

@section('content')
    <h1>Add New Rasid Ayni</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storerasidayni.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="main_branch_id_fk" class="form-label">Main Branch ID</label>
                <input type="number" class="form-control" id="main_branch_id_fk" name="main_branch_id_fk" required
                    value="{{ old('main_branch_id_fk') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sub_branch_id_fk" class="form-label">Sub Branch ID</label>
                <input type="number" class="form-control" id="sub_branch_id_fk" name="sub_branch_id_fk" required
                    value="{{ old('sub_branch_id_fk') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required
                    value="{{ old('date') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_ar" class="form-label">Date AR</label>
                <input type="text" class="form-control" id="date_ar" name="date_ar" value="{{ old('date_ar') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="publisher_name" class="form-label">Publisher Name</label>
                <input type="text" class="form-control" id="publisher_name" name="publisher_name"
                    value="{{ old('publisher_name') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="publisher" class="form-label">Publisher</label>
                <input type="number" class="form-control" id="publisher" name="publisher" value="{{ old('publisher') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sanf_code" class="form-label">Sanf Code</label>
                <input type="text" class="form-control" id="sanf_code" name="sanf_code" value="{{ old('sanf_code') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sanf_id" class="form-label">Sanf ID</label>
                <input type="number" class="form-control" id="sanf_id" name="sanf_id" value="{{ old('sanf_id') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sanf_name" class="form-label">Sanf Name</label>
                <input type="text" class="form-control" id="sanf_name" name="sanf_name" value="{{ old('sanf_name') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sanf_amount" class="form-label">Sanf Amount</label>
                <input type="number" step="any" class="form-control" id="sanf_amount" name="sanf_amount"
                    value="{{ old('sanf_amount') }}">
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Add Rasid Ayni</button>
            <a href="{{ route('admin.storerasidayni.index') }}" class="btn btn-secondary">Cancel</a>
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
