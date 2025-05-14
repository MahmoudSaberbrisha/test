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
                                <td class="py-2 px-4">{{ number_format($costCenter->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-700">لا توجد بيانات لعرضها.</p>
        @endif

        <h2>الحسابات التي لها مركز تكلفة</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم الحساب</th>
                    <th>اسم مركز التكلفة</th>
                    <th>الرصيد</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->cost_center_name ?? 'غير محدد' }}</td>
                        <td>{{ number_format($account->balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
