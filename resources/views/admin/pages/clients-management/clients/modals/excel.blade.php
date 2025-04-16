<div class="modal" id="excel" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h4 class="modal-title" id="excelLabel">{{ __("Upload Excel") }}</h4>
            </div>
            <form action="{{route(auth()->getDefaultDriver().'.import-excel')}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" class="dropify" name="excel_file" id="file" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __("Upload File") }}</button>
                    <a href="{{ asset('assets/admin/excel-sheets/clients.xlsx') }}" class="btn btn-info" download>
                        {{ __("Download Sample") }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>