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
                <button onclick="showAddChildModal({{ $child->id }})"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                    إضافة فرعي
                </button>
                <a href="{{ route(auth()->getDefaultDriver() . '.accounts.edit', $child->id) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200">
                    Edit
                </a>
                <form action="{{ route(auth()->getDefaultDriver() . '.accounts.destroy', $child->id) }}" method="POST"
                    class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if (count($child->children) > 0)
            <div id="account-{{ $child->id }}" class="mr-8 mt-2 space-y-2 hidden">
                @include('accountingdepartment::accounts.partials.children', ['account' => $child])
            </div>
        @endif
    </div>
@endforeach
