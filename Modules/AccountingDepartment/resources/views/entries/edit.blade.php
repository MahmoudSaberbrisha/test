@extends('accounting-department::entries.master')

@section('entries')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">تعديل قيد محاسبي</h2>
            <form action="{{ route('admin.entries.updateMultiple') }}" method="POST">
                @csrf
                @method('PUT')
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-3 py-2">التاريخ</th>
                            <th class="border border-gray-300 px-3 py-2">رقم القيد</th>
                            <th class="border border-gray-300 px-3 py-2">اسم الحساب</th>
                            <th class="border border-gray-300 px-3 py-2">رقم الحساب</th>
                            <th class="border border-gray-300 px-3 py-2">مركز التكلفة</th>
                            <th class="border border-gray-300 px-3 py-2">المرجع</th>
                            <th class="border border-gray-300 px-3 py-2">البيان</th>
                            <th class="border border-gray-300 px-3 py-2">اسم المستخدم</th>
                            <th class="border border-gray-300 px-3 py-2">مدين</th>
                            <th class="border border-gray-300 px-3 py-2">دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $index => $entry)
                            <tr>
                                <input type="hidden" name="entries[{{ $index }}][id]" value="{{ $entry->id }}">
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="date" name="entries[{{ $index }}][date]"
                                        value="{{ $entry->date }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][entry_number]"
                                        value="{{ $entry->entry_number }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][account_name]"
                                        value="{{ $entry->account_name }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][account_number]"
                                        value="{{ $entry->account_number }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][cost_center]"
                                        value="{{ $entry->cost_center }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][reference]"
                                        value="{{ $entry->reference }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][description]"
                                        value="{{ $entry->description }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="text" name="entries[{{ $index }}][account_name2]"
                                        value="{{ $entry->account_name2 }}" readonly
                                        class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="number" name="entries[{{ $index }}][debit]"
                                        value="{{ $entry->debit }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <input type="number" name="entries[{{ $index }}][credit]"
                                        value="{{ $entry->credit }}" required
                                        class="w-full border border-gray-300 rounded px-2 py-1">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تحديث الكل</button>
                </div>
            </form>
        </div>
    </div>
@endsection
