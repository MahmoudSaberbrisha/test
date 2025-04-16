@extends('accountingdepartment::accounts.index')
@section('cc')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-center mb-4">كشف الحساب</h1>



                <form method="GET"  action="{{ route(auth()->getDefaultDriver() . '.accounts.print', [$account->id,'account'=> request('id')])}}">

                <div class="w-1/4">
                        <label for="{{$account->id}}" class="block text-gray-700 mb-2">رقم العملية</label>
                        <input type="number" name="id" id="id"
                            value="{{ request('id') }}" class="w-full p-2 border rounded"
                            placeholder="ابحث برقم العملية">
                    </div>
                    <button type="submit">
                    go
                    </button>
        <div class="mb-4 flex justify-between">
            <div>
                <p>العميل: {{ $account->account_name }}</p>
                <p>رقم الحساب: {{ $account->account_number }}</p>
            </div>
            <div>
                <p>التاريخ: {{ now()->format('Y-m-d') }}</p>
                <p>الرصيد: {{ number_format($account->balance, 2) }}</p>
            </div>
        </div>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">التاريخ</th>
                    <th class="border p-2">البيان</th>
                    <th class="border p-2">دائن</th>

                    <th class="border p-2">مدين</th>
                    <th class="border p-2">الرصيد</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="border p-2">{{ $transaction->date }}</td>
                        <td class="border p-2">{{ $transaction->description }}</td>
                        <td class="border p-2 text-right">{{ number_format($transaction->debit, 2) }}</td>
                        <td class="border p-2 text-right">{{ number_format($transaction->credit, 2) }}</td>
                        <td class="border p-2 text-right">{{ number_format($transaction->debit- $transaction->credit, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
                    </form>

    </div>
@endsection
