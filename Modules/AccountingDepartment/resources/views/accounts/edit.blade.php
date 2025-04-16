@extends('admin.layouts.master')
@section('content')
    <html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Account</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        </link>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    </head>

    <body class="bg-gray-100 font-roboto">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Edit Account</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route(auth()->getDefaultDriver() . '.accounts.update', $account->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="account_name" class="block text-gray-700 font-medium mb-2">Account Name</label>
                        <input type="text" name="account_name" id="account_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ $account->account_name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="account_number" class="block text-gray-700 font-medium mb-2">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ $account->account_number }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="parent_id" class="block text-gray-700 font-medium mb-2">Parent Account
                            (optional)</label>
                        <input type="text" name="parent_id" id="parent_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ $account->parent_id }}">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Update
                            Account</button>
                        <a href="{{ route(auth()->getDefaultDriver() . '.accounts.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
@endsection
