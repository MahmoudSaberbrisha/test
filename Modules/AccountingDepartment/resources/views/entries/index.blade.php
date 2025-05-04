@extends('accounting-department::entries.master')
@section('entries')
    <link rel="stylesheet" href="{{ asset('assets') }}/style.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.4/dat.gui.min.js'></script>
    <script src="{{ asset('assets') }}/script.js"></script>

    <div class="mb-4" dir="rtl">
        <form method="GET" action="" class="flex items-center gap-4">
            <label for="per_page" class="text-sm font-medium text-gray-700">عدد العناصر:</label>
            <select name="per_page" id="per_page" class="border border-gray-300 rounded-md px-3 py-1 text-sm"
                onchange="this.form.submit()">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>
        <div class="flex justify-between mt-4">
            <button onclick="loadPreviousEntries()"
                class="LiquidButton bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                عرض السابق
            </button>
            <button onclick="loadNextEntries()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                عرض التالي
            </button>
        </div>
    </div>

    <script>
        function loadPreviousEntries() {
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = parseInt(urlParams.get('page') || 1);
            if (currentPage > 1) {
                urlParams.set('page', currentPage - 1);
                window.location.search = urlParams.toString();
            }
        }

        function loadNextEntries() {
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = parseInt(urlParams.get('page') || 1);
            urlParams.set('page', currentPage + 1);
            window.location.search = urlParams.toString();
        }
    </script>
    <div class="overflow-x-auto" dir="rtl">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-green-800 text-white">

                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">مركز التكلفة</th>
                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">المرجع</th>

                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">نوع القيد</th>
                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">تاريخ</th>
                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">رقم القيد</th>
                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">البيان</th>
                    <th class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">إجراء</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($entries as $entry)
                    <tr class="hover:bg-gray-100">

                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">{{ $entry->cost_center }}
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">{{ $entry->reference }}
                        </td>

                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">
                            {{ $entry->typeOfRestriction ? $entry->typeOfRestriction->restriction_type : 'N/A' }}</td>

                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">{{ $entry->date }}</td>

                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">{{ $entry->entry_number }}
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs">{{ $entry->description }}
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center w-auto max-w-xs"> <a
                                href="{{ route(auth()->getDefaultDriver() . '.entries.edit', $entry->id) }}"
                                class="text-blue-500 hover:underline"><i class="fas fa-edit"></i></a>
                            <form
                                action="{{ route(auth()->getDefaultDriver() . '.entries.destroy', $entry->entry_number) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('pagination')
    <div class="mt-4">
        {{ $entries->appends(['per_page' => request('per_page', 10)])->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preserve all existing query parameters when changing page size
            const perPageSelect = document.getElementById('per_page');
            const form = perPageSelect.closest('form');

            // Get all existing query parameters
            const urlParams = new URLSearchParams(window.location.search);

            // Add hidden inputs for all existing parameters except per_page
            urlParams.forEach((value, key) => {
                if (key !== 'per_page') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }
            });
        });
    </script>
@endpush
