@extends('admin.layouts.master')

@section('content')
    <h1>Add New Branch Setting</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storebranchsetting.store') }}" method="POST" style="color: white;">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control form-control-3d" id="title" name="title" required
                    maxlength="15" value="{{ old('title') }}" style="color: black;">
            </div>
            <div class="col-md-6 mb-3">
                <label for="br_code" class="form-label">Branch Code</label>
                <select class="form-select form-control-3d" id="br_code" name="br_code" style="color: black;">
                    <option value="">Select Branch Code</option>
                    <option value="A" {{ old('br_code') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('br_code') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ old('br_code') == 'C' ? 'selected' : '' }}>C</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="from_id" class="form-label">Parent Branch</label>
                <select class="form-select form-control-3d" id="from_id" name="from_id" style="color: black;">
                    <option value="">Select Parent Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('from_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="lat_map" class="form-label">Latitude</label>
                <input type="text" class="form-control form-control-3d" id="lat_map" name="lat_map" maxlength="15"
                    value="{{ old('lat_map') }}" style="color: black;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="long_map" class="form-label">Longitude</label>
                <input type="text" class="form-control form-control-3d" id="long_map" name="long_map" maxlength="15"
                    value="{{ old('long_map') }}" style="color: black;">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Branch Setting</button>
        <a href="{{ route('admin.storebranchsetting.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    <style>
        .form-control-3d {
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            box-shadow: none;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            color: black !important;
            background-color: #eaf2f8;
        }

        .form-control-3d:focus {
            box-shadow: 0 0 8px 2px #3498db;
            border-color: #2980b9;
            background-color: #ffffff;
            outline: none;
            color: black !important;
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
            color: black !important;
        }

        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: white !important;
        }
    </style>
@endsection
