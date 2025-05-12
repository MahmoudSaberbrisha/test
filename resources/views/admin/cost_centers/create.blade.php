@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>إضافة مركز تكلفة جديد</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.admin.cost-centers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسم مركز التكلفة</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <h3>الأفرع</h3>
            <div id="branches-container">
                <div class="branch-item mb-3">
                    <div class="form-group">
                        <label for="branches[0][name]">اسم الفرع</label>
                        <input type="text" name="branches[0][name]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="branches[0][description]">وصف الفرع</label>
                        <textarea name="branches[0][description]" class="form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn-danger remove-branch">حذف الفرع</button>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" id="add-branch">إضافة فرع جديد</button>

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let branchIndex = 1;

            document.getElementById('add-branch').addEventListener('click', function() {
                const container = document.getElementById('branches-container');
                const newBranch = document.createElement('div');
                newBranch.classList.add('branch-item', 'mb-3');
                newBranch.innerHTML = `
                <div class="form-group">
                    <label for="branches[${branchIndex}][name]">اسم الفرع</label>
                    <input type="text" name="branches[${branchIndex}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="branches[${branchIndex}][description]">وصف الفرع</label>
                    <textarea name="branches[${branchIndex}][description]" class="form-control"></textarea>
                </div>
                <button type="button" class="btn btn-danger remove-branch">حذف الفرع</button>
            `;
                container.appendChild(newBranch);

                newBranch.querySelector('.remove-branch').addEventListener('click', function() {
                    newBranch.remove();
                });

                branchIndex++;
            });

            document.querySelectorAll('.remove-branch').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.branch-item').remove();
                });
            });
        });
    </script>
@endsection
