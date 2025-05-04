@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Store Khazina</h1>
        <a href="{{ route('admin.storekhazina.create') }}" class="btn btn-primary">Add New Khazina Record</a>
    </div>

    <div class="row">
        @foreach ($khazinas as $khazina)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storekhazina.show', $khazina->id) }}"
                            class="text-white text-decoration-none">
                            {{ $khazina->name }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>ID:</strong> {{ $khazina->id }}</div>
                            <div class="col-6"><strong>Description:</strong> {{ $khazina->description }}</div>
                            <div class="col-6"><strong>Balance:</strong> {{ $khazina->balance }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storekhazina.edit', $khazina->id) }}"
                            class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.storekhazina.destroy', $khazina->id) }}" method="POST"
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
