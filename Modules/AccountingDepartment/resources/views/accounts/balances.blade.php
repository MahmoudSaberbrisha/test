@extends('accountingdepartment::accounts.index')
@section('cc')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Account Balances Preview</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: "Arial", sans-serif;
                background-color: #f3f4f6;
            }
        </style>
    </head>

    <body>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">ميزانيه الحساب</h1>
            <div class="bg-white shadow-md rounded-lg p-6 w-full">
                <table class="w-full border-collapse">
                    <thead >
                        <tr class="bg-gray-200 item-center">
                            <th class="px-4 py-2  text-gray-600 font-semibold">
                                اسم الحساب
                            </th>
                            <th class="px-4 py-2 text-gray-600 font-semibold">
                                رقم الحساب
                            </th>
                            <th class="px-4 py-2 text-gray-600 font-semibold">
                               الميزانيه
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr class="hover:bg-gray-100">
                                <td class="border-t px-4 py-2">{{ $account->account_name }}</td>
                                <td class="border-t px-4 py-2">{{ $account->account_number }}</td>
                                <td class="border-t px-4 py-2">{{ number_format($account->balance, 2) }}</td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>

    {{-- <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Account Balances</h1>

        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Account Name</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Account Number</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr class="hover:bg-gray-100">
                            <td class="border-t px-4 py-2">{{ $account->account_name }}</td>
                            <td class="border-t px-4 py-2">{{ $account->account_number }}</td>
                            <td class="border-t px-4 py-2">{{ number_format($account->balance, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
@endsection
{{--
<html dir="rtl" lang="ar">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   تقرير الطالب الشهري
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    /* From Uiverse.io by LightAndy1 */
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
            font-family: 'Arial', sans-serif;
            background-color: white;
        }
  </style>
 </head>
 <body class="flex flex-col items-center p-4">
  <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-6">
   <div class="flex justify-between items-center mb-4">
    <img alt="شعار المدرسة" class="w-20 h-20" height="100" src="https://storage.googleapis.com/a1aa/image/U-6rhCQXXaZFhg4aE7Ntyp0u5AQjINHjFflmAYvvCDY.jpg" width="100"/>
    <h1 class="text-3xl font-bold text-blue-900">
     تقرير الطالب الشهري
    </h1>
    <div>
    </div>
   </div>
   <h2 class="text-center text-xl text-blue-700 mb-4">
    مجموعات التفوق ... الأستاذ قطب عبد الله
   </h2>
   <div class="bg-yellow-200 p-4 rounded-lg mb-4">
    <div class="grid grid-cols-2 gap-4">
     <div>
      <label class="block text-gray-700">
       اسم الطالب
      </label>
      <input class="w-full p-2 border border-gray-300 rounded input " type="text"/>
     </div>
     <div>
      <label class="block text-gray-700">
       السنة الدراسية
      </label>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <label class="block text-gray-700">
       تقييم عن شهر
      </label>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <label class="block text-gray-700">
       التليفون
      </label>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
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
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      رياضيات
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      دراسات اجتماعية
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      علوم
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      تربية دينية إسلامية
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      تكنولوجيا المعلومات
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      المهارات المهنية
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      المجموع الكلي
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
     <div>
      <input class="w-full p-2 border border-gray-300 rounded input" type="text"/>
     </div>
    </div>
   </div>
   <h3 class="text-center text-lg text-blue-700 mb-4">
    المتابعة اليومية
   </h3>
   <div class="bg-red-100 p-4 rounded-lg mb-4">
    <table class="w-full text-center">
     <thead>
      <tr>
       <th class="p-2 border border-gray-300">
        عدد أيام الغياب
       </th>
       <th class="p-2 border border-gray-300">
        عدد الواجبات لم يتم تسليمها
       </th>
       <th class="p-2 border border-gray-300">
        المذاكرة اليومية خلال الشهر
       </th>
       <th class="p-2 border border-gray-300">
        السلوك العام خلال الشهر
       </th>
      </tr>
     </thead>
     <tbody>
      <tr>
       <td class="p-2 border border-gray-300">
        4 أيام
       </td>
       <td class="p-2 border border-gray-300">
        4 واجبات
       </td>
       <td class="p-2 border border-gray-300">
        جيد جدا
       </td>
       <td class="p-2 border border-gray-300">
        جيد جدا
       </td>
      </tr>
     </tbody>
    </table>
   </div>
   <div class="flex justify-between items-center mt-4">
    <img alt="شعار المدرسة" class="w-20 h-20" height="100" src="https://storage.googleapis.com/a1aa/image/U-6rhCQXXaZFhg4aE7Ntyp0u5AQjINHjFflmAYvvCDY.jpg" width="100"/>
    <div class="text-center">
     <p class="text-blue-900 font-bold">
      الأستاذ قطب عبد الله
     </p>
     <p class="text-blue-900">
      01098393633
     </p>
    </div>
   </div>
  </div>
 </body>
</html> --}}
