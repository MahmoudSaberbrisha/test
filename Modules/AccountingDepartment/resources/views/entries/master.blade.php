@extends('admin.layouts.master')
@section('content')
        <html lang="ar">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Accounting Entry</title>

    <script src="https://cdn.tailwindcss.com"></script>
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> --}}

            <script>
                function calculateDifference() {
                    let debitTotal = 0;
                    let creditTotal = 0;

                    document.querySelectorAll('.debit-input').forEach(input => {
                        debitTotal += parseFloat(input.value) || 0;
                    });

                    document.querySelectorAll('.credit-input').forEach(input => {
                        creditTotal += parseFloat(input.value) || 0;
                    });

                    document.getElementById('debit-total').innerText = debitTotal.toFixed(2);
                    document.getElementById('credit-total').innerText = creditTotal.toFixed(2);
                    document.getElementById('difference').value = (debitTotal - creditTotal).toFixed(2);
                }

                            function addRow() {
                                const tableBody = document.getElementById('table-body');
                                const newRow = document.createElement('tr');

                            newRow.innerHTML = `

                    <td class="border border-gray-300 py-2 px-4">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full">
                    </td>
                    <td class="border border-gray-300 py-2 px-4">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full">
                    </td>
                    <td class="border border-gray-300 py-2 px-4">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full">
                    </td>
                    <td class="border border-gray-300 py-2 px-4">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full">
                    </td>
                    <td class="border border-gray-300 py-2 px-4 bg-red-100">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full credit-input" oninput="calculateDifference()">
                    </td>
                    <td class="border border-gray-300 py-2 px-4">
                        <input type="text" class="border border-gray-300 rounded py-2 px-4 w-full debit-input" oninput="calculateDifference()">
                    </td>
                `;

                                            tableBody.insertBefore(newRow, tableBody.lastElementChild.previousElementSibling);
                                        }
                                    </script>
                            </head>
                            <style>
                                .input {
                                    border: none;
                                    outline: none;
                                    border-radius: 15px;
                                    padding: 1em;
                                    background-color: #ffffff;
                                    box-shadow: inset 2px 5px 10px rgba(0, 0, 0, 0.3);
                                    transition: 300ms ease-in-out;
                                }

            .input:focus {
                background-color: #ccc;
                transform: scale(1.05);
                box-shadow: 13px 13px 100px #969696,
                    -13px -13px 100px #ffffff;
            }

        </style>

        <body class="bg-gray-100 p-4">
            <div class="container mx-auto bg-white shadow-md rounded-lg p-4">
                <div class="flex space-x-2 space-x-reverse   items-center mb-4" dir="rtl">
                    <a href="{{ route(auth()->getDefaultDriver() . '.entries.create') }}"
                        class="bg-green-500 text-white py-2 px-4 rounded" style="color: rgb(3, 180, 3)">اضافة قيد
                        محاسبي</a>
                    <div class="flex space-x-2 space-x-reverse">
                        <a href="{{ route(auth()->getDefaultDriver() . '.entries.index') }}"
                            class="bg-yellow-500 text-white py-2 px-4 rounded">قيود قيد
                            المراجعة</a>
                        <a href="{{ route(auth()->getDefaultDriver() . '.entries.index') }}"
                            class="bg-yellow-500 text-white py-2 px-4 rounded">قيود تمت
                            المراجعة</a>
                        <a href="{{ route(auth()->getDefaultDriver() . '.entries.index') }}"
                            class="bg-yellow-500 text-white py-2 px-4 rounded">قيود تم
                            التامين</a>
                    </div>
                </div>
                @yield('entries')
            </div>
        </body>

        </html>
@endsection
