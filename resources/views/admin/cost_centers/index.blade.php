@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>مراكز التكلفة</h1>
        <a href="{{ route(auth()->getDefaultDriver() . '.admin.cost-centers.create') }}" class="btn btn-primary mb-3">إضافة
            مركز
            تكلفة جديد</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الوصف</th>
                    <th>الأفرع</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($costCenters as $costCenter)
                    <tr>
                        <td>{{ $costCenter->name }}</td>
                        <td>{{ $costCenter->description }}</td>
                        <td>
                            <ul>
                                @foreach ($costCenter->branches as $branch)
                                    <li>{{ $branch->name }} - {{ $branch->description }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="{{ route(auth()->getDefaultDriver() . '.admin.cost-centers.edit', $costCenter->id) }}"
                                class="btn btn-sm btn-warning">تعديل</a>
                            <form
                                action="{{ route(auth()->getDefaultDriver() . '.admin.cost-centers.destroy', $costCenter->id) }}"
                                method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
