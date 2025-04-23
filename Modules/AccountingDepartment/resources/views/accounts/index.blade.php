@extends('admin.layouts.master')
@section('content')
    <html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>الحسابات</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    </head>

    <body class="bg-gray-100 font-roboto flex flex-col min-h-screen">
        <div class="container mx-auto p-4 flex-grow">
            <h1 class="text-2xl font-bold mb-4">الحسابات</h1>
            <div class="flex space-x-2 space-x-reverse mb-3">
                <a href="{{ route(auth()->getDefaultDriver() . '.accounts.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">إضافة
                    حساب</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.accounts.index') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">شجرة
                    الدليل المحاسبي</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.accounts.balances') }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">أرصدة
                    الحسابات</a>
                @if ($accounts->isNotEmpty())
                    <a href="{{ route(auth()->getDefaultDriver() . '.accounts.statement', $accounts->first()->id) }}"
                        class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">بيان
                        الحسابات</a>
                @else
                    <button disabled class="bg-purple-300 text-white px-4 py-2 rounded-md cursor-not-allowed">بيان
                        الحسابات</button>
                @endif
                @if ($accounts->isNotEmpty())
                    <a href="{{ route(auth()->getDefaultDriver() . '.accounts.print', $accounts->first()->id) }}"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">طباعة
                        الدليل المحاسبي</a>
                @else
                    <button disabled class="bg-red-300 text-white px-4 py-2 rounded-md cursor-not-allowed">طباعة
                        الدليل المحاسبي</button>
                @endif
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @yield('cc')
        </div>
        </div>
        </div>

        <script>
            function toggleChildren(id) {
                const element = document.getElementById(id);
                const icon = document.getElementById(`icon-${id}`);
                if (element) {
                    element.classList.toggle('hidden');
                    if (icon) {
                        icon.classList.toggle('rotate-180');
                    }
                }
            }

            // Add a JS variable for the API base URL
            const nextChildAccountNumberUrlTemplate =
                "{{ route(auth()->getDefaultDriver() . '.accounts.nextChildAccountNumber', ['parentId' => 'PARENT_ID_PLACEHOLDER']) }}";

            function showAddChildModal(parentId) {
                document.getElementById('parent_id').value = parentId;

                // Replace placeholder with actual parentId
                const url = nextChildAccountNumberUrlTemplate.replace('PARENT_ID_PLACEHOLDER', parentId);

                // Fetch next child account number from API
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.next_account_number) {
                            document.getElementById('account_number').value = data.next_account_number;
                        } else {
                            document.getElementById('account_number').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next child account number:', error);
                        document.getElementById('account_number').value = '';
                    });

                document.getElementById('addChildModal').classList.remove('hidden');
            }

            function hideAddChildModal() {
                document.getElementById('addChildModal').classList.add('hidden');
            }
        </script>

        <div id="addChildModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">إضافة حساب فرعي</h3>
                    <form action="{{ route(auth()->getDefaultDriver() . '.accounts.store') }}" method="POST"
                        class="mt-4">
                        @csrf
                        <input type="hidden" id="parent_id" name="parent_id">
                        <div class="mb-4">
                            <label for="account_name" class="block text-gray-700 text-sm font-bold mb-2">اسم الحساب</label>
                            <input type="text" name="account_name" id="account_name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="account_number" class="block text-gray-700 text-sm font-bold mb-2">رقم
                                الحساب</label>
                            <input type="text" name="account_number" id="account_number"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="account_status" class="block text-gray-700 font-medium mb-2">حاله الحساب</label>
                            <select name="account_status" id="account_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">اختر حالة الحساب</option>
                                <option value="رئيسي">رئيسي</option>
                                <option value="فرعي">فرعي</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="account_type" class="block text-gray-700 font-medium mb-2">نوع الحساب</label>
                            <select name="account_type" id="account_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>

                                <option value="">اختر نوع الحساب</option>
                                <option value="دائن">دائن</option>
                                <option value="مدين">مدين</option>
                            </select>
                        </div>
                        <div class="flex justify-between px-4 py-3">
                            <button type="button" onclick="hideAddChildModal()"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                إلغاء
                            </button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
