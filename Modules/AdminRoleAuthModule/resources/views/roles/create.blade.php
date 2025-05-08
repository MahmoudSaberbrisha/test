@extends('admin.layouts.master')
@section('page_title', __('Create Role'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Roles'), __('Create Role')]])
@endsection

@push('css')
    <style type="text/css">
        .no-dots {
            list-style-type: none;
        }

        .group-span:before, .group-span:after {
            top: 7px !important;
            right: 10px !important;
        }

        .group-span {
            color: white;
        }

        .group-container {
            column-count: 3;
            column-gap: 1.25rem;
        }
    </style>
@endpush

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route(auth()->getDefaultDriver().'.roles.store')}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="row mb-20 m-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('Guard Name')}} </label>
                                        <select name="guard_name" class="form-control" required>
                                            <option value="">{{__('Select')}}</option>
                                            @foreach ($guards as $guard)
                                                <option value="{{$guard}}" {{old('guard_name')==$guard?'selected':''}}>{{__($guard)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('Role Name')}} </label>
                                        <input name="name" value="{{old('name')}}" type="text" id="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="group-container mb-5 w-100">
                                    @foreach ($permissionsWithoutGroups as $permission)
                                        <ul class="no-dots group-ul">
                                            <li>
                                                <label class="ckbox mt-3">
                                                    <input name="permissions[]" value="{{$permission->name}}"  type="checkbox" class="subOption">
                                                    <span class="tx-13">{{__($permission->name)}}</span>
                                                </label>
                                            </li>
                                        </ul>
                                    @endforeach
                                    @foreach ($groups as $group)
                                        <ul class="no-dots group-ul">
                                            <li>
                                                <label class="ckbox badge bg-dark" style="height: 30px;">
                                                    <input type="checkbox" id="group-{{$group->id}}" data-checkall-group="{{$group->id}}">
                                                    <span class="tx-13 group-span">{{$group->group_name}}</span>
                                                </label>
                                                <ul class="no-dots">
                                                @foreach ($group->permissions as $permission)
                                                    <li>
                                                        <label class="ckbox mt-3">
                                                            <input name="permissions[]" value="{{$permission->name}}"  type="checkbox" class="subOption" data-group="{{$group->id}}">
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
        for (const checkall of document.querySelectorAll("[data-checkall-group]")) {
          checkall.addEventListener('change', event => {
            for (const checkbox of document.querySelectorAll('[data-group="' + event.target.dataset.checkallGroup + '"]')) {
              checkbox.checked = event.target.checked
            }
          })
        }

        for (const checkbox of document.querySelectorAll("[data-group]")) {
          checkbox.addEventListener('change', event => {
            const group = event.target.dataset.group
            const checkall = document.querySelector('[data-checkall-group="' + group + '"]')
            const singles = document.querySelectorAll("[data-group='" + group + "']")
            const singlesChecked = document.querySelectorAll("[data-group='" + group + "']:checked")

            if (singlesChecked.length === singles.length) {
              checkall.indeterminate = false
              checkall.checked = true
            }
            else if (singlesChecked.length === 0) {
              checkall.indeterminate = false
              checkall.checked = false
            }
            else {
              checkall.indeterminate = true
              checkall.checked = false
            }
          })
        }
    </script>
@endpush
