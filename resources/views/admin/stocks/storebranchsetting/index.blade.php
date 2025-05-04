@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Branch Settings</h1>
        <a href="{{ route('admin.storebranchsetting.create') }}" class="btn btn-primary">Add New Branch Setting</a>
    </div>

    <div class="row">
        @foreach ($branchsettings as $branch)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <strong>{{ $branch->title }}</strong>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>ID:</strong> {{ $branch->id }}</div>
                            <div class="col-6"><strong>Branch Code:</strong> {{ $branch->br_code }}</div>
                            <div class="col-6"><strong>Parent Branch:</strong>
                                {{ $branch->parentBranch ? $branch->parentBranch->title : '' }}</div>
                            <div class="col-6"><strong>Latitude:</strong> {{ $branch->lat_map }}</div>
                            <div class="col-6"><strong>Longitude:</strong> {{ $branch->long_map }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storebranchsetting.show', $branch->id) }}"
                            class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.storebranchsetting.edit', $branch->id) }}"
                            class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.storebranchsetting.destroy', $branch->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
