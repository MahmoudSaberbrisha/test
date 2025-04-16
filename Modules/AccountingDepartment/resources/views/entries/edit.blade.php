@extends('accounting-department::entries.master')

@section('entries')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">تعديل قيد محاسبي</h2>
            <form action="{{ route(auth()->getDefaultDriver() . '.entries.update', $entry->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">التاريخ</label>
                    <input type="date" name="date" id="date"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->date }}" required>
                </div>
                <div class="mb-4">
                    <label for="entry_number" class="block text-gray-700">رقم القيد</label>
                    <input type="text" name="entry_number" id="entry_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->entry_number }}" required>
                </div>
                <div class="mb-4">
                    <label for="account_name" class="block text-gray-700">اسم الحساب</label>
                    <input type="text" name="account_name" id="account_name"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_name }}" required>
                </div>
                <div class="mb-4">
                    <label for="account_number" class="block text-gray-700">رقم الحساب</label>
                    <input type="text" name="account_number" id="account_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_number }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="cost_center" class="block text-gray-700">مركز التكلفة</label>
                    <input type="text" name="cost_center" id="cost_center"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->cost_center }}" required>
                </div>
                <div class="mb-4">
                    <label for="reference" class="block text-gray-700">المرجع</label>
                    <input type="text" name="reference" id="reference"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->reference }}" required>
                </div>
                <div class="mb-4">
                    <label for="debit" class="block text-gray-700">مدين</label>
                    <input type="number" name="debit" id="debit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->debit }}" required>
                </div>
                <div class="mb-4">
                    <label for="credit" class="block text-gray-700">دائن</label>
                    <input type="number" name="credit" id="credit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->credit }}" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تحديث</button>
            </form>
        </div>
    </div>
@endsection

{{--
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل قيد محاسبي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">تعديل قيد محاسبي</h2>
            <form action="{{ route('entries.update', $entry->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">التاريخ</label>
                    <input type="date" name="date" id="date"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->date }}" required>
                </div>
                <div class="mb-4">
                    <label for="entry_number" class="block text-gray-700">رقم القيد</label>
                    <input type="text" name="entry_number" id="entry_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->entry_number }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="account_name" class="block text-gray-700">اسم الحساب</label>
                    <input type="text" name="account_name" id="account_name"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_name }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="account_number" class="block text-gray-700">رقم الحساب</label>
                    <input type="text" name="account_number" id="account_number"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->account_number }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="cost_center" class="block text-gray-700">مركز التكلفة</label>
                    <input type="text" name="cost_center" id="cost_center"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->cost_center }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="reference" class="block text-gray-700">المرجع</label>
                    <input type="text" name="reference" id="reference"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->reference }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="debit" class="block text-gray-700">مدين</label>
                    <input type="number" name="debit" id="debit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->debit }}" required>
                </div>
                <div class="mb-4">
                    <label for="credit" class="block text-gray-700">دائن</label>
                    <input type="number" name="credit" id="credit"
                        class="border border-gray-300 rounded px-2 py-1 w-full" value="{{ $entry->credit }}" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تحديث</button>
            </form>
        </div>
    </div>
</body>

</html>

                        <!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة القيود</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

{{-- <body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">قائمة القيود</h2>

            <form action="{{ route('entries.store') }}" method="POST">
                @csrf
                <div class="flex justify-between items-center mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">اضافه قيد</button>

                </div>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-green-800 text-white">
                            <th class="border border-gray-300 px-4 py-2">إجراء</th>
                            <th class="border border-gray-300 px-4 py-2">تاريخ</th>
                            <th class="border border-gray-300 px-4 py-2">رقم القيد</th>
                            <th class="border border-gray-300 px-4 py-2">اسم الحساب</th>
                            <th class="border border-gray-300 px-4 py-2">رقم الحساب</th>
                            <th class="border border-gray-300 px-4 py-2">مركز التكلفة</th>
                            <th class="border border-gray-300 px-4 py-2">المرجع</th>
                            <th class="border border-gray-300 px-4 py-2">مدين</th>
                            <th class="border border-gray-300 px-4 py-2">دائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td class="border border-gray-300 px-4 py-2">
                                <input type="date" name="date"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="entry_number"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="account_name"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="account_number"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="cost_center"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="text" name="reference"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number" name="debit"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number" name="credit"
                                    class="border border-gray-300 rounded px-2 py-1 w-full" required>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>

</html> --}}
