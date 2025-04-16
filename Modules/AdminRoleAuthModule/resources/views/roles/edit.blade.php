@extends('admin.layouts.master')
@section('page_title', __('Update Role'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Roles'), __('Update Role')]])
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
                        <livewire:adminroleauthmodule::edit-role :role_id="$role_id" />
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