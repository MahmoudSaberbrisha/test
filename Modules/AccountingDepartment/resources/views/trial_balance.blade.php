@extends('accounting-department::master')

@section('coco')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ميزان المراجعة (Trial Balance)</h1>
        <div class="bg-white shadow-md rounded p-4">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">الحساب (Account)</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">مدين (Debit)</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">دائن (Credit)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $account->account_name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">
                                {{ number_format($account->total_debit, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">
                                {{ number_format($account->total_credit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">الإجمالي (Total)</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">
                            {{ number_format($accounts->sum('total_debit'), 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">
                            {{ number_format($accounts->sum('total_credit'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
