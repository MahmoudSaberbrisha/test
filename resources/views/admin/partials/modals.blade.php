<div class="modal" id="modal-danger" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content modal-content-demo">
			<form method="" action="">
                @csrf
                {{ method_field('DELETE') }}
				<div class="modal-body">
					<h6>{{__('Are you sure?')}}</h6>
					<p>{{__('If you proceed, you will lose this data.')}}</p>
				</div>
				<div class="modal-footer">
					<button class="btn ripple btn-danger" type="submit" autofocus>{{__('Yes, delete it')}}</button>
					<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Cancel')}}</button>
				</div>
		</div>
	</div>
</div>
