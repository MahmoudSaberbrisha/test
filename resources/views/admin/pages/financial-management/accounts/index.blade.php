@extends('admin.layouts.master')
@section('page_title', __("Accounts"))
@section('breadcrumb')
	@include('admin.partials.breadcrumb', ['breads' => [__('Financial Management'), __('Accounts')]])
@endsection

@push('css')
	<style>
        .tree-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
        }
        .tree-item:hover {
            background-color: #f8f9fa;
        }
        .tree-icons {
            display: flex;
            gap: 14px;
            margin-right: auto;
        }
        .tree-icons i {
            cursor: pointer;
        }
        .toggle-switch {
            position: relative;
            width: 40px;
            height: 20px;
            background: #ccc;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .toggle-switch::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            top: 1px;
            left: 2px;
            transition: all 0.3s;
        }
        .toggle-switch.active {
            background: #28a745;
        }
        .toggle-switch.active::before {
            left: 20px;
        }
        .tree ul {
            list-style-type: none;
            border-right: 1px solid #ddd;
            display: none;
        }
        .tree li.open > ul {
            display: block;
        }
        .toggle-btn {
            font-size: 16px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
		<div class="row row-sm">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-0">{{__('Accounts Tree')}}</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div>
					</div>
					<div class="card-body">
						<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add" class="btn btn-success mg-b-20">{{__('Add Account')}} <i class="typcn typcn-plus"></i></a>
						<div class="container">
					        <h3 class="text-center mb-4"> </h3>
					        <div class="col-8">
					        	<ul class="tree" style="list-style-type: none;">
						            <li class="open">
						                <div class="tree-item">
						                    <span onclick="toggleBranch(this)">
						                        <i class="toggle-btn fas fa-minus"></i>
						                        <i class="fas fa-folder"></i> الأصول
						                    </span>
						                    <div class="tree-icons">
						                        <i class="fas fa-edit text-primary"></i>
						                        <i class="fas fa-trash text-danger"></i>
						                        <div class="toggle-switch" onclick="toggleSwitch(this)"></div>
						                    </div>
						                </div>
						                <ul>
						                    <li class="open">
						                        <div class="tree-item">
						                            <span onclick="toggleBranch(this)">
						                                <i class="toggle-btn fas fa-minus"></i>
						                                <i class="fas fa-building"></i> الأصول الثابتة
						                            </span>
						                            <div class="tree-icons">
						                                <i class="fas fa-edit text-primary"></i>
						                                <i class="fas fa-trash text-danger"></i>
						                                <div class="toggle-switch" onclick="toggleSwitch(this)"></div>
						                            </div>
						                        </div>
						                        <ul>
						                            <li>
						                                <div class="tree-item">
						                                    <span>
						                                        <i class="fas fa-car"></i> المركبات
						                                    </span>
						                                    <div class="tree-icons">
						                                        <i class="fas fa-edit text-primary"></i>
						                                        <i class="fas fa-trash text-danger"></i>
						                                        <div class="toggle-switch" onclick="toggleSwitch(this)"></div>
						                                    </div>
						                                </div>
						                            </li>
						                        </ul>
						                    </li>
						                </ul>
						            </li>
						            <li>
						                <div class="tree-item">
						                    <span onclick="toggleBranch(this)">
						                        <i class="toggle-btn fas fa-plus"></i>
						                        <i class="fas fa-wallet"></i> الخصوم
						                    </span>
						                    <div class="tree-icons">
						                        <i class="fas fa-edit text-primary"></i>
						                        <i class="fas fa-trash text-danger"></i>
						                        <div class="toggle-switch" onclick="toggleSwitch(this)"></div>
						                    </div>
						                </div>
						            </li>
						        </ul>
					        </div>
					    </div>
					</div>
				</div>
			</div>
		</div>

		@include('admin.pages.financial-management.accounts.modals.create')
		@include('admin.pages.financial-management.accounts.modals.edit')

	</div>
	<!-- Container closed -->
</div>
@endsection

@push('js')
	<script>
        function toggleBranch(element) {
            let parentLi = element.closest('li');
            let toggleIcon = element.querySelector('.toggle-btn');
            if (parentLi.classList.contains('open')) {
                parentLi.classList.remove('open');
                toggleIcon.classList.replace('fa-minus', 'fa-plus');
            } else {
                parentLi.classList.add('open');
                toggleIcon.classList.replace('fa-plus', 'fa-minus');
            }
        }
        function toggleSwitch(element) {
            element.classList.toggle('active');
        }
    </script>
@endpush
