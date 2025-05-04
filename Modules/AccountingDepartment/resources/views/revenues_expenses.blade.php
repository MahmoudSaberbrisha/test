@extends('accounting-department::master')

@section('coco')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">الإيرادات والمصروفات</h1>

        <table class="min-w-full border">
            <thead>
                <tr>
                    <th class="border p-2">اسم الحساب </th>
                    <th class="border p-2">رقم الحساب </th>
                    <th class="border p-2">الايرادات والتبرعات</th>
                    <th class="border p-2"> المصروفات</th>
                    <th class="border p-2">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBalance = 0;
                    $totalBalance2 = 0;
                @endphp
                @foreach ($accounts as $account)
                    @php
                        $totalBalance += $account->balance;
                        $totalBalance2 += $account->balance2;
                        $total = $account->balance - $account->balance2;
                    @endphp
                    <tr>
                        <td class="border p-2">{{ $account->account_name }}</td>
                        <td class="border p-2">{{ $account->account_number }}</td>
                        <td class="border p-2">{{ $account->balance }}</td>
                        <td class="border p-2">{{ $account->balance2 }}</td>
                        <td class="border p-2">{{ $total }}</td>
                    </tr>
                @endforeach
                <tr class="font-bold bg-gray-200">
                    <td class="border p-2" colspan="2">الإجمالي الكلي</td>
                    <td class="border p-2">{{ $totalBalance }}</td>
                    <td class="border p-2">{{ $totalBalance2 }}</td>
                    <td class="border p-2">{{ $totalBalance - $totalBalance2 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
