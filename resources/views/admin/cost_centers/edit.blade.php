@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل مركز تكلفة</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route(auth()->getDefaultDriver() .'.admin.cost-centers.update', $costCenter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">اسم مركز التكلفة</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $costCenter->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $costCenter->description) }}</textarea>
            </div>

            <h3>الأفرع</h3>
            <div id="branches-container">
                @foreach ($costCenter->branches as $index => $branch)
                    <div class="branch-item mb-3">
                        <input type="hidden" name="branches[{{ $index }}][id]" value="{{ $branch->id }}">
                        <div class="form-group">
                            <label for="branches[{{ $index }}][name]">اسم الفرع</label>
                            <input type="text" name="branches[{{ $index }}][name]" class="form-control"
                                value="{{ old('branches.' . $index . '.name', $branch->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="branches[{{ $index }}][description]">وصف الفرع</label>
                            <textarea name="branches[{{ $index }}][description]" class="form-control">{{ old('branches.' . $index . '.description', $branch->description) }}</textarea>
                        </div>
                        <button type="button" class="btn btn-danger remove-branch">حذف الفرع</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary mb-3" id="add-branch">إضافة فرع جديد</button>

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let branchIndex = {{ $costCenter->branches->count() }};

            document.getElementById('add-branch').addEventListener('click', function() {
                const container = document.getElementById('branches-container');
                const newBranch = document.createElement('div');
                newBranch.classList.add('branch-item', 'mb-3');
                newBranch.innerHTML = `
                <div class="form-group">
                    <label for="branches[\${branchIndex}][name]">اسم الفرع</label>
                    <input type="text" name="branches[\${branchIndex}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="branches[\${branchIndex}][description]">وصف الفرع</label>
                    <textarea name="branches[\${branchIndex}][description]" class="form-control"></textarea>
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
