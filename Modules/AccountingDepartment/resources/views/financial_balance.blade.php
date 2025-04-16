@extends('accounting-department::master')
@section('coco')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">الميزان المالي</h1>
        @if ($accounts->count() > 0)
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto border rounded">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-green-800 text-white">
                            <th class="py-2 px-4">رقم الحساب</th>
                            <th class="py-2 px-4">اسم الحساب</th>
                            <th class="py-2 px-4">الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $account->account_number }}</td>
                                <td class="py-2 px-4">{{ $account->account_name }}</td>
                                <td class="py-2 px-4">{{ number_format($account->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-700">لا توجد بيانات لعرضها.</p>
        @endif
    </div>
@endsection