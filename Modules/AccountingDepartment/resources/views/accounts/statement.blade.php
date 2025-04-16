@extends('accountingdepartment::accounts.index')
@section('cc')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">بيان الحسابات</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <form method="GET" class="flex space-x-4" action="{{ route(auth()->getDefaultDriver() . '.accounts.statement', [$account->id,'account'=>request('id')])}}">
                    <div class="w-1/4">
                        <label for="from_date" class="block text-gray-700 mb-2">من تاريخ</label>
                        <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                            class="w-full p-2 border rounded">
                    </div>
                    <div class="w-1/4">
                        <label for="to_date" class="block text-gray-700 mb-2">إلى تاريخ</label>
                        <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                            class="w-full p-2 border rounded">
                    </div>
                    <div class="w-1/4">
                        <label for="id" class="block text-gray-700 mb-2">رقم العملية</label>
                        <input type="number" name="id" id="id"
                            value="{{ request('id') }}" class="w-full p-2 border rounded"
                            placeholder="ابحث برقم العملية">
                    </div>
                    <div class="w-1/4 flex items-end">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">عرض</button>
                        <a href="{{ route(auth()->getDefaultDriver() . '.accounts.statement', $account->id) }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">إعادة تعيين</a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">التاريخ</th>
                            <th class="px-4 py-2">البيان</th>
                            <th class="px-4 py-2">مدين</th>
                            <th class="px-4 py-2">دائن</th>
                            <th class="px-4 py-2">الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalBalance = 0; // متغير لتخزين مجموع الأرصدة
                        @endphp
                        @foreach ($transactions as $transaction)
                            @php
                                $currentBalance = $transaction->debit - $transaction->credit; // حساب الرصيد الحالي
                                $totalBalance += $currentBalance; // إضافة الرصيد الحالي إلى المجموع
                            @endphp
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $transaction->date }}</td>
                                <td class="px-4 py-2">{{ $transaction->description }}</td>
                                <td class="px-4 py-2">{{ number_format($transaction->credit, 2) }}</td>
                                <td class="px-4 py-2">{{ number_format($transaction->debit, 2) }}</td>
                                <td class="px-4 py-2">{{ number_format($currentBalance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-200">
                            <td colspan="4" class="px-4 py-2 text-right font-bold">المجموع:</td>
                            <td class="px-4 py-2 text-right font-bold">{{ number_format($totalBalance, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
