@extends('accounting-department::master')
@section('coco')
    <div class="container p-4">
        <form method="GET" action="{{ route(auth()->getDefaultDriver() . '.account.movement') }}" class="mb-4">
            <div class="flex flex-wrap justify-between items-center mb-4 space-x-4 space-x-reverse">
                <div class="flex space-x-4 space-x-reverse" style="flex-wrap: nowrap; overflow-x: auto;">
                    <div class="w-full sm:w-auto" style="flex: 1 1 auto; min-width: 150px;">
                        <label for="account-number" class="block text-gray-700">اختار الحساب</label>
                        <select name="account_id" id="account-number"
                            class="border border-gray-300 rounded p-2 w-full sm:w-auto"
                            onchange="updateAccountDetails(this)">
                            <option value="">إختر الحساب</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" data-name="{{ $account->account_name }}"
                                    data-number="{{ $account->account_number }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_name }} ({{ $account->account_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-auto" style="flex: 1 1 auto; min-width: 150px;">
                        <label for="account-number" class="block text-gray-700">رقم الحساب</label>
                        <input type="text" name="account_number" id="account_number"
                            class="border border-gray-300 rounded p-2 w-full sm:w-auto"
                            value="{{ $accounts->firstWhere('id', request('account_id'))?->account_number }}" readonly>
                    </div>
                    <div class="w-full sm:w-auto" style="flex: 1 1 auto; min-width: 150px;">
                        <label for="account-number" class="block text-gray-700">اسم الحساب</label>
                        <input type="text" name="account_name" id="account_name"
                            class="border border-gray-300 rounded p-2 w-full sm:w-auto"
                            value="{{ $accounts->firstWhere('id', request('account_id'))?->account_name }}" readonly>
                    </div>
                    <div class="w-full sm:w-auto" style="flex: 1 1 auto; min-width: 150px;">
                        <label for="from-date" class="block text-gray-700">الفترة من</label>
                        <input type="date" name="from_date" id="from-date"
                            class="border border-gray-300 rounded p-2 w-full sm:w-auto" value="{{ request('from_date') }}">
                    </div>
                    <div class="w-full sm:w-auto" style="flex: 1 1 auto; min-width: 150px;">
                        <label for="to-date" class="block text-gray-700">إلى</label>
                        <input type="date" name="to_date" id="to-date"
                            class="border border-gray-300 rounded p-2 w-full sm:w-auto" value="{{ request('to_date') }}">
                    </div>
                </div>
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded mt-6 sm:mt-0 w-full sm:w-auto">بحث</button>
            </div>
        </form>

        <div class="bg-white p-4 rounded shadow">
            @if (isset($entries) && $entries->count() > 0)
                <div class="overflow-x-auto overflow-y-auto max-h-96 block">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-green-800 text-white">
                                <th class="py-2 px-4">م</th>
                                <th class="py-2 px-4">التاريخ</th>
                                <th class="py-2 px-4">نوع القيد</th>
                                <th class="py-2 px-4">رقم القيد</th>
                                <th class="py-2 px-4">رقم المرجع</th>
                                <th class="py-2 px-4">البيان</th>
                                <th class="py-2 px-4">المدين</th>
                                <th class="py-2 px-4">الدائن</th>
                                <th class="py-2 px-4">الرصيد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4">{{ $entry->date }}</td>
                                    <td class="py-2 px-4">{{ $entry->entry_type }}</td>
                                    <td class="py-2 px-4">{{ $entry->entry_number }}</td>
                                    <td class="py-2 px-4">{{ $entry->reference_number }}</td>
                                    <td class="py-2 px-4">{{ $entry->description }}</td>
                                    <td class="py-2 px-4">{{ number_format($entry->credit, 2) }}</td>
                                    <td class="py-2 px-4">{{ number_format($entry->debit, 2) }}</td>
                                    <td class="py-2 px-4">{{ number_format($entry->debit - $entry->credit, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-700">لا توجد بيانات لعرضها.</p>
            @endif
        </div>
        @if (isset($entries) && $entries->count() > 0)
            @php
                $totalDebit = $entries->sum('debit');
                $totalCredit = $entries->sum('credit');
                $totalDifference = $totalDebit - $totalCredit;
            @endphp
            <div class="bg-yellow-500 text-white p-2 rounded mt-4">
                <div class="flex justify-between">
                    <div>الإجمالي</div>
                    <div>رصيد الحساب</div>
                </div>
                <div class="flex justify-between bg-gray-200 text-black p-2 rounded">
                    <div>{{ number_format($totalDifference, 2) }}</div>
                    <div>{{ number_format($totalDifference, 2) }}</div>
                </div>
            </div>
        @endif
    </div>

@endsection
