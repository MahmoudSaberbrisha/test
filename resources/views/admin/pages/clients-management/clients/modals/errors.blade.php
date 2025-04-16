<div class="modal" id="errorModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h4 class="modal-title" id="errorModalLabel">{{ __("Import Errors") }}</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{__('Row')}}</th>
                            <th>{{__('Error')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session('import_errors'))
                            @foreach (session('import_errors') as $error)
                                <tr>
                                    <td>{{ $error['row'] }}</td>
                                    <td>{{ $error['error'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn ripple btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>