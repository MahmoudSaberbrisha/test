<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{__('Add Account')}}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route(auth()->getDefaultDriver().'.accounts.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <div class="row m-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{__('Name')}} <small class="text-info"> ({{getDefaultLanguageCode()}})</small></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">{{__('Account Number')}}</label>
                                <input type="text" name="code" id="code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_type_id">{{__('Account Type')}}</label>
                                <select class="form-control" name="account_type_id" required>
                                    <option value="">{{__('Select')}}</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_id">{{__('Parent Account')}}</label>
                                <select class="form-control" name="parent_id">
                                    <option value="">{{__('Select')}}</option>
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon">{{__('Icon')}}</label>
                                <input type="text" name="icon" id="icon" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="is_payment" id="is_payment" class="form-check-input">
                                <label class="form-check-label" for="is_payment">{{__('Is Payment Account')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="active" id="active" class="form-check-input" checked>
                                <label class="form-check-label" for="active">{{__('Active')}}</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">{{__('Save')}}</button>
                    <button class="btn btn-light" data-dismiss="modal" type="button">{{__('Close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
