<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Chart of Accounts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Chart of Accounts</h1>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center cursor-pointer"
                    onclick="toggleDropdown('accounts-dropdown')">
                    <h2 class="text-xl font-semibold text-gray-700">
                        <i class="fas fa-tree mr-2"></i> شجرة الحسابات
                    </h2>
                    <i class="fas fa-chevron-down text-gray-500"></i>
                </div>
                <ul id="accounts-dropdown" class="list-none pl-6 mt-2 hidden">
                    @foreach ($accounts as $account)
                        <li class="border-b py-4">
                            <div class="flex justify-between items-center cursor-pointer"
                                onclick="showAccountsByParentId('{{ $account->id }}')">
                                <div class="flex items-center">
                                    <img alt="Icon representing Account" class="mr-3" height="40"
                                        src="https://storage.googleapis.com/a1aa/image/YpdlRP1JM1U55sfmYMqs22NKyjQLTi_M2fo51pSgKlY.jpg"
                                        width="40" />
                                    <span
                                        class="text-lg font-semibold text-gray-700">{{ $account->account_name }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                            <ul id="dropdown-{{ $account->id }}" class="list-none pl-6 mt-2 hidden">
                                <li class="border-b py-2 text-gray-600 flex items-center">
                                    <img alt="Icon representing Account Number" class="mr-2" height="30"
                                        src="https://storage.googleapis.com/a1aa/image/IJSc64FvS7fAmlDysUcUoS9Sy5cDBuqmHSyQimQTErU.jpg"
                                        width="30" />
                                    الحساب البنكي: {{ $account->account_number }}
                                </li>
                                @foreach ($accounts as $child)
                                    @if ($child->parent_id == $account->id)
                                        <li class="border-b py-2 text-gray-600 flex items-center pl-4">
                                            <img alt="Icon representing Child Account" class="mr-2" height="30"
                                                src="https://storage.googleapis.com/a1aa/image/_KUJTtXCQjS54xJKVpFXwBLiSwpxC05vtfqU2cTkiZw.jpg"
                                                width="30" />
                                            الحساب الفرعي: {{ $child->account_name }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            console.log("Toggling dropdown:", dropdownId); // Debugging line
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                console.log("Dropdown visibility toggled:", dropdown.classList.contains('hidden')); // Debugging line
            } else {
                console.error("Dropdown not found:", dropdownId); // Debugging line
            }
        }

        function showAccountsByParentId(parentId) {
            const allDropdowns = document.querySelectorAll('ul[id^="dropdown-"]');
            allDropdowns.forEach(dropdown => {
                dropdown.classList.add('hidden'); // Hide all dropdowns initially
            });

            const selectedDropdown = document.getElementById('dropdown-' + parentId);
            if (selectedDropdown) {
                selectedDropdown.classList.remove('hidden'); // Show the selected dropdown
            }
        }
    </script>
</body>

</html>
