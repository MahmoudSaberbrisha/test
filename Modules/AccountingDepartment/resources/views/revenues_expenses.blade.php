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
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td class="border p-2">{{ $account->account_name }}</td>
                        <td class="border p-2">{{ $account->account_number }}</td>
                        <td class="border p-2">{{ $account->balance }}</td>
                        <td class="border p-2">{{ $account->balance2 }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
