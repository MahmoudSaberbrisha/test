@extends('admin.layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Masrof Asnaf Far3</h1>
        <a href="{{ route('admin.storemasrofasnaffar3.create') }}" class="btn btn-primary">Add New Masrof Asnaf Far3</a>
    </div>

    <div class="row">
        @foreach ($masrofasnaf as $record)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-header bg-primary text-white py-1 px-2">
                        <a href="{{ route('admin.storemasrofasnaffar3.show', $record->id) }}"
                            class="text-white text-decoration-none">
                            {{ $record->main_branch_fk }}
                        </a>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2">
                            <div class="col-6"><strong>ID:</strong> {{ $record->id }}</div>
                            <div class="col-6"><strong>Sub Branch FK:</strong> {{ $record->sub_branch_fk }}</div>
                            <div class="col-6"><strong>Sarf Rkm:</strong> {{ $record->sarf_rkm }}</div>
                            <div class="col-6"><strong>Sarf To:</strong> {{ $record->sarf_to }}</div>
                            <div class="col-6"><strong>Sanf Code:</strong> {{ $record->sanf_code }}</div>
                            <div class="col-6"><strong>Available Amount:</strong> {{ $record->available_amount }}</div>
                            <div class="col-6"><strong>Sanf Amount:</strong> {{ $record->sanf_amount }}</div>
                            <div class="col-6"><strong>One Price Sell:</strong> {{ $record->one_price_sell }}</div>
                            <div class="col-6"><strong>Date:</strong> {{ $record->date }}</div>
                            <div class="col-6"><strong>Date Ar:</strong> {{ $record->date_ar ?? '' }}</div>
                            <div class="col-6"><strong>Publisher:</strong> {{ $record->publisher }}</div>
                            <div class="col-6"><strong>Publisher Name:</strong> {{ $record->publisher_name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between py-1 px-2">
                        <a href="{{ route('admin.storemasrofasnaffar3.edit', $record->id) }}"
                            class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.storemasrofasnaffar3.destroy', $record->id) }}" method="POST"
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
