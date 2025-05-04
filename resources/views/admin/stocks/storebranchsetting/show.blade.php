@extends('admin.layouts.master')

@section('content')
    <h1>Branch Setting Details</h1>

    <div class="card p-3" style="background-color: #eaf2f8; color: black; border-radius: 8px; box-shadow: none;">
        <div class="mb-3">
            <label class="form-label">ID:</label>
            <div>{{ $branch->id }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Title:</label>
            <div>{{ $branch->title }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Branch Code:</label>
            <div>{{ $branch->br_code }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Parent Branch:</label>
            <div>{{ $branch->parentBranch ? $branch->parentBranch->title : '' }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Latitude:</label>
            <div>{{ $branch->lat_map }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Longitude:</label>
            <div>{{ $branch->long_map }}</div>
        </div>
    </div>

    <a href="{{ route('admin.storebranchsetting.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    <a href="{{ route('admin.storebranchsetting.edit', $branch->id) }}" class="btn btn-primary mt-3">Edit</a>

    <style>
        label.form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: black !important;
        }
    </style>
@endsection
