@extends('accountingdepartment::accounts.index')
@section('cc')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4 flex items-center space-x-4">
            <a href="{{ route('admin.admin.accounts.exportExcel') }}"
               class="inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Export Excel
            </a>
            <form action="{{ route('admin.admin.accounts.importExcel') }}" method="POST" enctype="multipart/form-data" class="inline-block">
                @csrf
                <input type="file" name="import_file" accept=".xlsx,.xls" required class="inline-block">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Import Excel
                </button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <div class="max-h-[70vh] overflow-y-auto pr-2">
                <div class="space-y-2">
                    @foreach ($accounts as $account)
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    @if (count($account->children) > 0)
                                        <button style="height: 30px!important"
                                            onclick="toggleChildren('account-{{ $account->id }}')"
                                            class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    @else
                                        <span class="w-4"></span>
                                    @endif
                                    <span class="font-medium">{{ $account->account_name }}</span>
                                    <span class="text-gray-500">({{ $account->account_number }})</span>
                                </div>
                                <div class="space-x-2 space-x-reverse">
                                    <button style="height: 30px!important" onclick="showAddChildModal({{ $account->id }})"
                                        class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 inline-block">إضافة
                                        فرعي</button>
                                    <a href="{{ route(auth()->getDefaultDriver() . '.accounts.edit', $account->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 inline-block">Edit</a>
                                    <form
                                        action="{{ route(auth()->getDefaultDriver() . '.accounts.destroy', $account->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button style="height: 30px!important" type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if (count($account->children) > 0)
                            <div id="account-{{ $account->id }}" class="mr-8 mt-2 space-y-2">
                                @foreach ($account->children as $child)
                                    <div class="bg-gray-50 p-3 rounded shadow-sm">
                                        <div class="flex justify-between items-center cursor-pointer"
                                            onclick="toggleChildren('account-{{ $child->id }}')">
                                            <div class="flex items-center space-x-2 space-x-reverse">
                                                @if (count($child->children) > 0)
                                                    <span class="text-gray-500 transform transition-transform duration-200"
                                                        id="icon-account-{{ $child->id }}">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </span>
                                                @else
                                                    <span class="w-4"></span>
                                                @endif
                                                <span class="text-gray-700 font-medium">{{ $child->account_name }}
                                                    ({{ $child->account_number }})
                                                </span>
                                            </div>
                                            <div class="flex space-x-2 space-x-reverse">
                                                <button style="height: 30px!important"
                                                    onclick="showAddChildModal({{ $child->id }})"
                                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                                                    إضافة فرعي
                                                </button>
                                                <a style="height: 30px!important"
                                                    href="{{ route(auth()->getDefaultDriver() . '.accounts.edit', $child->id) }}"
                                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200">
                                                    Edit
                                                </a>
                                                <form
                                                    action="{{ route(auth()->getDefaultDriver() . '.accounts.destroy', $child->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="height: 30px!important" type="submit"
                                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    @if (count($child->children) > 0)
                                        <div id="account-{{ $child->id }}" class="mr-8 mt-2 space-y-2 hidden">
                                            @include('accountingdepartment::accounts.partials.children', [
                                                'account' => $child,
                                            ])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endsection
