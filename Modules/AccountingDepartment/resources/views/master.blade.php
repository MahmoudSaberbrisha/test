@extends('admin.layouts.master')
@section('content')


    <div class="h-screen overflow-y-auto">
        <div class="container p-4">
            <div class="flex flex-wrap justify-center space-x-4 mx-auto w-full"
                style="justify-content: center !important; ">
                <a href="{{ route(auth()->getDefaultDriver() . '.account.movement') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded sm:w-auto"
                    style="margin-left: 60px;margin-right: 60px">حركة حساب</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.revenues.expenses') }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded sm:w-auto" style="margin-left: 60px">الإيرادات
                    والمصروفات</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.trial.balance') }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded sm:w-auto" style="margin-left: 60px">ميزان
                    المراجعة</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.financial.balance') }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded sm:w-auto" style="margin-left: 60px">الميزان
                    المالي</a>
                <a href="{{ route(auth()->getDefaultDriver() . '.cost.centers.report') }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded sm:w-auto" style="margin-left: 60px;">تقرير مراكز
                    التكلفة</a>
            </div>

            @yield('coco')
        </div>

        <script>
            function updateAccountDetails(selectElement) {
                const selectedAccount = selectElement.options[selectElement.selectedIndex];
                const accountNameInput = document.getElementById('account_name');
                const accountNumberInput = document.getElementById('account_number');

                accountNameInput.value = selectedAccount.getAttribute('data-name');
                accountNumberInput.value = selectedAccount.getAttribute('data-number');
            }
        </script>

@endsection