<div>
    <div class="mb-4">
        <input type="text" wire:model="search" placeholder="Search accounts..."
            class="border rounded px-3 py-2 w-full" />
    </div>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('name')">
                    الحساب (Account)
                    @if($sortField === 'name')
                        @if($sortDirection === 'asc')
                            &uarr;
                        @else
                            &darr;
                        @endif
                    @endif
                </th>
                <th class="border border-gray-300 px-4 py-2 text-right cursor-pointer" wire:click="sortBy('debit')">
                    مدين (Debit)
                    @if($sortField === 'debit')
                        @if($sortDirection === 'asc')
                            &uarr;
                        @else
                            &darr;
                        @endif
                    @endif
                </th>
                <th class="border border-gray-300 px-4 py-2 text-right cursor-pointer" wire:click="sortBy('credit')">
                    دائن (Credit)
                    @if($sortField === 'credit')
                        @if($sortDirection === 'asc')
                            &uarr;
                        @else
                            &darr;
                        @endif
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $account)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $account->translate(app()->getLocale())->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">
                        {{ number_format($account->entries->sum('debit'), 2) }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-right">
                        {{ number_format($account->entries->sum('credit'), 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">No accounts found.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="font-bold bg-gray-100">
                <td class="border border-gray-300 px-4 py-2">الإجمالي (Total)</td>
                <td class="border border-gray-300 px-4 py-2 text-right">
                    {{ number_format($accounts->sum(fn($a) => $a->entries->sum('debit')), 2) }}
                </td>
                <td class="border border-gray-300 px-4 py-2 text-right">
                    {{ number_format($accounts->sum(fn($a) => $a->entries->sum('credit')), 2) }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>