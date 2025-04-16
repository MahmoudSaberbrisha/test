<div>
    <form action="{{route(auth()->getDefaultDriver().'.roles.update', $role['id'])}}" method="POST" enctype="multipart/form-data" data-parsley-validate x-data x-init="
        $nextTick(() => initializeParsley());
    ">
    @csrf
    @method('PUT')
        <div class="row col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{__('Guard Name')}} </label>
                    <select name="guard_name" wire:model="guard" class="form-control" wire:change="changeGuard" required>
                        <option value="">{{__('Select')}}</option>
                        @foreach ($guards as $guard)
                            <option value="{{$guard}}" {{$role['guard_name']==$guard?'selected':''}}>{{__($guard)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{__('Role Name')}} </label>
                    <input name="name" value="{{$role['name']}}" type="text" id="name" class="form-control" required>
                </div>
            </div>
        </div>
        <div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
            <div class="spinner-border" role="status">
                <span class="sr-only">{{__('Loading...')}}</span>
            </div>
        </div>
        <div class="group-container mb-5" wire:loading.remove>
            @foreach ($permissionsWithoutGroups as $permission)
                <ul class="no-dots group-ul">
                    <li>
                        <label class="ckbox mt-3">
                            <input name="permissions[]" value="{{$permission->id}}"  type="checkbox" class="subOption" {{in_array($permission->id, array_column($role->permissions->toArray(), 'id'))?'checked':''}}>
                            <span class="tx-13">{{__($permission->name)}}</span>
                        </label>
                    </li>
                </ul>
            @endforeach
            @foreach ($groups as $group)
                <ul class="no-dots">
                    <li>
                        <label class="ckbox badge bg-dark" style="height: 30px;">
                            <input type="checkbox" id="group-{{$group->id}}" data-checkall-group="{{$group->id}}" {{$group->permissions->count() == $role->permissions->where('permission_group_id', $group->id)->count()?'checked':''}}>
                            <span class="tx-13 group-span">{{$group->group_name}}</span>
                        </label>
                        <ul class="no-dots">
                        @foreach ($group->permissions as $permission)
                            <li>
                                <label class="ckbox mt-3">
                                    <input name="permissions[]" value="{{$permission->id}}"  type="checkbox" class="subOption" data-group="{{$group->id}}" {{in_array($permission->id, array_column($role->permissions->toArray(), 'id'))?'checked':''}}>
                                    <span class="tx-13">{{__($permission->name)}}</span>
                                </label>
                            </li>
                        @endforeach
                        </ul>
                    </li>
                </ul>
            @endforeach
        </div>
        @include('adminroleauthmodule::includes.save-buttons')
    </form>
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('checkBoxes',()=>{
            setTimeout(() => {
                /*if ($('.cc:checked').length === $('.cc').length) {
                    $('.all').prop('checked', true);
                } else {
                    $('.all').prop('checked', false);
                }*/
            }, 20);
        });

        function initializeParsley() {
            const form = document.getElementById('my-form-id');
            if (form) {
                $(form).parsley().reset();
                $(form).parsley();
            }
        }
    </script>
@endpush
