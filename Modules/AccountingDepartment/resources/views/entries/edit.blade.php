@extends('accounting-department::entries.master')

@section('entries')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">تعديل قيد محاسبي</h2>
            <form action="{{ route(auth()->getDefaultDriver() . '.entries.update', $entry->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">التاريخ</label>
                    <input type="date" name="date" id="date"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->date }}" required>
                </div>
                <div class="mb-4">
                    <label for="entry_number" class="block text-gray-700">رقم القيد</label>
                    <input type="text" name="entry_number" id="entry_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->entry_number }}" required>
                </div>
                <div class="mb-4">
                    <label for="account_name" class="block text-gray-700">اسم الحساب</label>
                    <input type="text" name="account_name" id="account_name"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_name }}" required>
                </div>
                <div class="mb-4">
                    <label for="account_number" class="block text-gray-700">رقم الحساب</label>
                    <input type="text" name="account_number" id="account_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_number }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="cost_center" class="block text-gray-700">مركز التكلفة</label>
                    <input type="text" name="cost_center" id="cost_center"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->cost_center }}" required>
                </div>
                <div class="mb-4">
                    <label for="reference" class="block text-gray-700">المرجع</label>
                    <input type="text" name="reference" id="reference"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->reference }}" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">البيان</label>
                    <input type="text" name="description" id="description"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->description }}" required>
                </div>
                <div class="mb-4">
                    <label for="debit" class="block text-gray-700">مدين</label>
                    <input type="number" name="debit" id="debit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->debit }}" required>
                </div>
                <div class="mb-4">
                    <label for="credit" class="block text-gray-700">دائن</label>
                    <input type="number" name="credit" id="credit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->credit }}" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تحديث</button>
            </form>
        </div>
    </div>
@endsection
