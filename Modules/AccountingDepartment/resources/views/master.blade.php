@extends('admin.layouts.master')
@section('content')
{{-- <html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        تقرير الطالب الشهري
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&amp;display=swap" rel="stylesheet" />

    <style>
        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 190px;
        }

        .input {
            font-family: "Montserrat", sans-serif;
            width: 100%;
            height: 45px;
            padding-left: 2.5rem;
            box-shadow: 0 0 0 1.5px #2b2c37, 0 0 25px -17px #000;
            border: 0;
            border-radius: 12px;
            background-color: #f9fafc;
            outline: none;
            color: #bdbecb;
            transition: all 0.25s cubic-bezier(0.19, 1, 0.22, 1);
            cursor: text;
            z-index: 0;
        }

        .input::placeholder {
            color: #bdbecb;
        }

        .input:hover {
            box-shadow: 0 0 0 2.5px #2f303d, 0px 0px 25px -15px #000;
        }

        .input:active {
            transform: scale(0.95);
        }

        .input:focus {
            box-shadow: 0 0 0 2.5px #2f303d;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            fill: #bdbecb;
            width: 1rem;
            height: 1rem;
            pointer-events: none;
            z-index: 1;
        }

        body {
            font-family: 'Amiri', serif;

            background-color: white;
        }

        /* From Uiverse.io by akshat-patel28 */
        .card {
            width: auto;
            height: 150px;
            background: white;
            border-radius: 200px;
            box-shadow: white, white -5px 0px 250px;
            display: flex;
            color: white;
            justify-content: center;
            position: relative;
            flex-direction: column;
            background: linear-gradient(to right, white, white);
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: rgb(0, 0, 0) 5px 10px 50px, rgb(0, 0, 0) -5px 0px 250px;
        }

        .time-text {
            font-size: 70px;
            margin-top: 0px;
            margin-left: 15px;
            font-weight: 600;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .time-sub-text {
            font-size: 15px;
            margin-left: 5px;
        }

        .day-text {
            font-size: 25px;
            margin-top: 0px;
            margin-left: 15px;
            font-weight: 500;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }



        .moon {
            font-size: 30px;
            position: absolute;
            right: 10px;
            top: 10px;
            transition: all 0.3s ease-in-out;
        }

        .card:hover>.moon {
            font-size: 30px;
        }
    </style>
</head>

<body class="flex flex-col items-center p-4">
    <div class="w-full max-w-4xl  shadow-lg rounded-lg p-6 relative">
        <img alt="خلفية مزخرفة" class="absolute inset-0 w-full h-full object-cover  z-0" src="{{url('assets/bg.jpg')}}" />
        <div class="relative z-10">

            <div class="card items-center mb-4 rounded-full">
                <p class="time-text " style="color: rgb(47, 47, 97)"><span>تقرير الطالب الشهري</span></p>
                <p class="day-text" style="color: rgb(47, 47, 97)">
                    مجموعات التفوق ... الأستاذ قطب عبد الله
                </p>
                <img src="{{url('assets/logo.jpg')}}" alt="صورة" class="moon rounded-full w-32 h-32" />
            </div>

            <div class="bg-yellow-200 p-4 rounded-lg mb-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">
                            اسم الطالب
                        </label>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <label class="block text-gray-700">
                            السنة الدراسية
                        </label>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <label class="block text-gray-700">
                            تقييم عن شهر
                        </label>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <label class="block text-gray-700">
                            التليفون
                        </label>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                </div>
            </div>
            <h3 class="text-center text-lg text-blue-700 mb-4">
                درجات الامتحانات الشهرية
            </h3>
            <div class="bg-green-100 p-4 rounded-lg mb-4">
                <div class="grid grid-cols-4 gap-4 text-center">
                    <div class="font-bold">
                        اسم الامتحان
                    </div>
                    <div class="font-bold">
                        درجة الامتحان
                    </div>
                    <div class="font-bold">
                        درجة الطالب
                    </div>
                    <div class="font-bold">
                        الدرجة النهائية
                    </div>
                    <div>
                        لغة عربية
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        رياضيات
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        دراسات اجتماعية
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        علوم
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        تربية دينية إسلامية
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        تكنولوجيا المعلومات
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        المهارات المهنية
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div>
                        <input class="w-full p-2 border border-gray-300 rounded input" type="text" />
                    </div>
                    <div
                        class="border-4 border-green-500 border-opacity-20 p-4 col-span-4 flex items-center justify-between space-x-6 rtl:space-x-reverse">
                        <div class="text-center font-bold w-1/4 text-lg">
                            المجموع الكلي
                        </div>
                        <div class="w-1/4">
                            <input class="w-full p-4 border border-gray-300 rounded input text-lg" type="text"
                                placeholder="درجة الامتحان" />
                        </div>
                        <div class="w-1/4">
                            <input class="w-full p-4 border border-gray-300 rounded input text-lg" type="text"
                                placeholder="درجة الطالب" />
                        </div>
                        <div class="w-1/4">
                            <input class="w-full p-4 border border-gray-300 rounded input text-lg" type="text"
                                placeholder="الدرجة النهائية" />
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center text-lg text-blue-700 mb-4" style="font-size: 20px">
                المتابعة اليومية
            </h3>
            <div class="relative bg-red-500 p-4 rounded-lg shadow-lg w-full">
                <div class="bg-white p-4 rounded-lg mb-4">
                    <table class="w-full text-center">
                        <thead>
                            <tr>
                                <th class="p-2 border border-gray-300" style="font-size: 20px">
                                    البند
                                </th>
                                <th class="p-2 border border-gray-300" style="font-size: 20px">
                                    القيمة
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2 border border-gray-300">
                                    عدد أيام الغياب
                                </td>
                                <td class="p-2 border border-gray-300">
                                    4 أيام
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 border border-gray-300">
                                    عدد الواجبات لم يتم تسليمها
                                </td>
                                <td class="p-2 border border-gray-300">
                                    4 واجبات
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    المذاكرة اليومية خلال الشهر
                                </td>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    جيد جدا
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    السلوك العام خلال الشهر
                                </td>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    جيد جدا
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    حالة دفع المصروفات
                                </td>
                                <td class="p-2 border border-gray-300" style="font-size: 20px">
                                    مفلس
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <img alt="شعار " class="absolute bottom-0 left-0 w-32 h-32 rounded-full border-2 border-white"
                    src="{{url('assets/logo.jpg')}}" />
                <img alt="أوراق درجات" class="absolute bottom-1 right-2 w-48 h-48"
                    style="border-radius: 20px;margin: 10px" src="{{url('assets/a.jpg')}}" />
            </div>
            <div class="flex justify-center items-center mt-4">
                <div class="flex flex-col items-center">
                    <p class="text-blue-900 font-bold" style="font-size: 20px">
                        الأستاذ قطب عبد الله
                    </p>
                    <p class="text-blue-900">
                        01098393633
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>

</html> --}}


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
