@extends('accounting-department::entries.master')

@section('entries')
    <div class="container mx-auto bg-white shadow-md rounded-lg p-4" dir="ltr">
        <form action="{{ route(auth()->getDefaultDriver() . '.entries.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-6 gap-4 mb-4" dir="ltr">

                <div class="col-span-1">
                    <label for="date" class="block text-gray-700">التاريخ</label>
                    <input type="date" name="date" id="date"
                        class="border input border-gray-300 rounded px-4 py-2 w-full" required>
                </div>
                <div class="col-span-1">
                    <label for="entry-number" class="block text-gray-700">رقم القيد</label>
                    <input type="text" name="entry_number" id="entry_number" value="{{ $nextEntryNumber ?? '' }}"
                        class="border input border-gray-300 rounded px-4 py-2 w-full" required>
                </div>
                <div class="col-span-1">
                    <label for="entry-status" class="block text-gray-700">حالة القيد</label>
                    <select name="entry_status" id="entry-status"
                        class="border input border-gray-300 rounded py-2 px-4 w-full">
                        <option>قيد المراجعة</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="type_of_restriction" class="block text-gray-700">نوع القيد</label>
                    <select name="type_of_restriction" id="type_of_restriction"
                        class="border input border-gray-300 rounded py-2 px-4 w-full">
                        <option value="1-قيد إفتتاحي">قيد إفتتاحي</option>
                        <option value="2-قيد يومية">قيد يومية</option>
                        <option value="3-قيد ألي">قيد ألي</option>
                        <option value="4-قيد تسوية">قيد تسوية</option>
                        <option value="5-قيد سند قبض">قيد سند قبض</option>
                        <option value="6-قيد سند صرف">قيد سند صرف</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full scroll-y-auto text-sm text-center font-light border-collapse">
                    <thead>
                        <tr class="bg-green-700 text-white">
                            <th class="border border-gray-300 py-2 px-4">الإجراء</th>
                            <th class="border border-gray-300 py-2 px-4">البيان</th>

                            <th class="border border-gray-300 py-2 px-4">المرجع</th>
                            <th class="border border-gray-300 py-2 px-4">مركز التكلفة</th>
                            <th class="border border-gray-300 py-2 px-4">إسم الحساب</th>
                            <th class="border border-gray-300 py-2 px-4">رقم الحساب</th>
                            <th class="border border-gray-300 py-2 px-4">مدين</th>

                            <th class="border border-gray-300 py-2 px-4">دائن</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="input w-full">
                        <tr>
                            <td class="border border-gray-300 py-2 px-4 text-center" rowspan="100">
                                <button type="button" class="bg-blue-500 text-black rounded-full p-2 input"
                                    onclick="addRow()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td>
                                <input type="text" style="width:350px" name="entries[0][description]" id="description"
                                    class="border border-gray-300 rounded px-2 input py-3 w-full" required>
                            </td>
                            <td>
                                <input type="text" name="entries[0][reference]" id="reference"
                                    class="border border-gray-300 rounded input px-2 py-3 w-full" required>
                            </td>
                            <td>
                                <input type="text" name="entries[0][cost_center]" id="cost_center"
                                    class="border border-gray-300 rounded input px-2 py-3 w-full" required>
                            </td>
                            <td>
                                <input type="hidden" name="entries[0][account_name]" id="account_name_0" value="">
                                <select name="entries[0][chart_of_account_id]" id="chart_of_account_id_0"
                                    class="border border-gray-300 rounded px-2 py-3 input w-full account-select"
                                    data-index="0" onchange="updateAccountDetails(this)" required>
                                    <option value="">إختر الحساب</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" data-name="{{ $account->account_name }}"
                                            data-number="{{ $account->account_number }}">{{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="entries[0][account_number]" id="account_number_0" value=""
                                    class="border border-gray-300 rounded px-2  input py-3 w-full" required readonly>
                            </td>
                            <td class="border py-1 px-1 bg-red-100">
                                <input type="number" name="entries[0][credit]" id="credit" value=0.00
                                    style="width:120px"
                                    class="border  border-gray-300 rounded py-3 input px-4 w-full credit-input"
                                    oninput="calculateDifference()">
                            </td>
                            <td class="border border-gray-300">
                                <input type="number" name="entries[0][debit]" id="debit" value=0.00
                                    style="width:120px" class="border border-gray-300 rounded px-2 input py-3 debit-input"
                                    oninput="calculateDifference()" required>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <input type="text" style="width:350px" name="entries[1][description]"
                                    id="description2" class="border border-gray-300 rounded px-2 input py-3 w-full"
                                    required>
                            </td>
                            <td>
                                <input type="text" name="entries[1][reference]" id="reference2"
                                    class="border border-gray-300 rounded px-2 input py-3 w-full" required>
                            </td>
                            <td>
                                <input type="text" name="entries[1][cost_center]" id="cost_center2"
                                    class="border border-gray-300 rounded px-2 input py-3 w-full" required>
                            </td>
                            <td>
                                <input type="hidden" name="entries[1][account_name]" id="account_name_1"
                                    value="">
                                <select name="entries[1][chart_of_account_id]" id="chart_of_account_id_1"
                                    class="border border-gray-300 rounded px-2 py-3 input w-full account-select"
                                    data-index="1" onchange="updateAccountDetails(this)" required>
                                    <option value="">إختر الحساب</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" data-name="{{ $account->account_name }}"
                                            data-number="{{ $account->account_number }}">{{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="entries[1][account_number]" id="account_number_1"
                                    value="" class="border border-gray-300 rounded px-2  input py-3 w-full" required
                                    readonly>
                            </td>
                            <td class="border py-1 px-1 bg-red-100">
                                <input type="number" name="entries[1][credit]" id="credit" value=0.00
                                    class="border border-gray-300 rounded py-3 input px-4 w-full credit-input"
                                    style="width: 120px" oninput="calculateDifference()">
                            </td>
                            <td>
                                <input type="number" style="width: 120px" name="entries[1][debit]" id="debit"
                                    value=0.00 class="border border-gray-300 rounded input px-3 py-3 w-full debit-input"
                                    oninput="calculateDifference()" required>
                            </td>

                        </tr>

                        <tr class="bg-green-100">
                            <td class=" py-3  text-center" colspan="5">الإجمالي</td>
                            <td style="width: 120px" class=" py-3  text-center" id="credit-total">0.00</td>
                            <td style="width: 120px" class=" py-3   text-center" id="debit-total">0.00</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 py-1 px-1 text-center" colspan="6">الفرق بين الجانبين
                            </td>
                            <td class="border border-gray-300 py-1 px-1 text-center"><input id="difference" readonly
                                    style="width: 120px" type="number"
                                    class="border border-gray-300 py-2  input px-4 text-center" name="totel" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-between items-center mt-4">
                <div class="flex space-x-2">
                    <button class="bg-blue-500 text-white py-2 px-4 rounded flex items-center">
                        <i class="fas fa-search ml-2"></i> البحث
                    </button>
                    <button class="bg-gray-700 text-white py-2 px-4 rounded flex items-center">
                        <i class="fas fa-paperclip ml-2"></i> اضافة مرفق
                    </button>
                    <button class="bg-purple-500 text-white py-2 px-4 rounded flex items-center">
                        <i class="fas fa-print ml-2"></i> طباعة
                    </button>
                </div>
                <div class="flex space-x-2">
                    <button class="bg-red-500 text-white py-2 px-4 rounded flex items-center">
                        <i class="fas fa-trash ml-2"></i> حذف
                    </button>
                    <button type="submit" class="bg-green-700 text-white py-2 px-4 rounded flex items-center">
                        <i class="fas fa-save ml-2"></i> حفظ
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function updateAccountDetails(selectElement) {
            const selectedAccount = selectElement.options[selectElement.selectedIndex];
            const index = selectElement.getAttribute('data-index');
            const accountNameInput = document.getElementById('account_name_' + index);
            const accountNumberInput = document.getElementById('account_number_' + index);

            accountNameInput.value = selectedAccount.getAttribute('data-name');
            accountNumberInput.value = selectedAccount.getAttribute('data-number');
        }

        function addRow() {
            const tableBody = document.getElementById('table-body');
            // Count only data rows (exclude total and difference rows)
            const dataRows = tableBody.querySelectorAll('tr:not(.bg-green-100):not(:last-child)');
            const newIndex = dataRows.length;

            const chartOfAccountOptions = `
                <option value="">إختر الحساب</option>
                    @foreach ($accounts as $account)
                        @if ($account->parent_id !== null)
                            <option value="{{ $account->id }}" data-name="{{ $account->account_name }}" data-number="{{ $account->account_number }}">{{ $account->account_name }}</option>
                        @endif
                    @endforeach
            `;

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <input type="text" style="width:350px" name="entries[${newIndex}][description]" class="border border-gray-300 rounded px-2 input py-3 w-full" required>
                </td>
                <td>
                    <input type="text" name="entries[${newIndex}][reference]" class="border border-gray-300 rounded input px-2 py-3 w-full" required>
                </td>
                <td>
                    <input type="text" name="entries[${newIndex}][cost_center]" class="border border-gray-300 rounded input px-2 py-3 w-full" required>
                </td>
                <td>
                    <input type="hidden" name="entries[${newIndex}][account_name]" id="account_name_${newIndex}" value="">
                    <select name="entries[${newIndex}][chart_of_account_id]" id="chart_of_account_id_${newIndex}" class="border border-gray-300 rounded px-2 py-3 input w-full account-select" data-index="${newIndex}" required onchange="updateAccountDetails(this)">
                        ${chartOfAccountOptions}
                    </select>
                </td>
                <td>
                    <input type="text" name="entries[${newIndex}][account_number]" id="account_number_${newIndex}" value="" class="border border-gray-300 rounded px-2  input py-3 w-full" required readonly>
                </td>
                <td class="border py-1 px-1 bg-red-100">
                    <input type="number" name="entries[${newIndex}][credit]" value=0.00 class="border border-gray-300 rounded py-3 input px-4 w-full credit-input" style="width: 120px" oninput="calculateDifference()">
                </td>
                <td>
                    <input type="number" style="width: 120px" name="entries[${newIndex}][debit]" value=0.00 class="border border-gray-300 rounded input px-3 py-3 w-full debit-input" oninput="calculateDifference()" required>
                </td>
            `;

            tableBody.insertBefore(newRow, dataRows[dataRows.length - 1]);
        }
    </script>
@endsection
