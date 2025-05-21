@extends('accounting-department::master')
@section('coco')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">تقرير مراكز التكلفة</h1>
        @if ($costCenters->count() > 0)
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto border rounded">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-green-800 text-white">
                            <th class="py-2 px-4">رقم مركز التكلفة</th>
                            <th class="py-2 px-4">اسم مركز التكلفة</th>
                            <th class="py-2 px-4">الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costCenters as $costCenter)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ $costCenter->account_number }}</td>
                                <td class="py-2 px-4">{{ $costCenter->name }}</td>
                                <td class="py-2 px-4">{{ number_format($costCenter->balance ?? 0, 2) }}</td>
                            </tr>
                            @if (isset($costCenter->accounts) && $costCenter->accounts->count() > 0)
                                <tr>
                                    <td colspan="3" class="px-4 py-2 bg-gray-100">
                                        <table class="min-w-full bg-white border">
                                            <thead>
                                                <tr class="bg-gray-300">
                                                    <th class="py-1 px-2">رقم الحساب</th>
                                                    <th class="py-1 px-2">اسم الحساب</th>
                                                    <th class="py-1 px-2">الرصيد</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($costCenter->accounts as $account)
                                                    <tr>
                                                        <td class="py-1 px-2">{{ $account->account_number }}</td>
                                                        <td class="py-1 px-2">{{ $account->account_name }}</td>
                                                        <td class="py-1 px-2">{{ number_format($account->balance, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-700">لا توجد بيانات لعرضها.</p>
        @endif


    </div>
@endsection
