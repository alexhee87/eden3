
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover datatable" style="width:100%;" data-table-source="{{ url($table['source']) }}" data-table-title="{{ $table['title'] }}" id="{{ $table['id'] }}" {!! array_key_exists('form',$table) ? 'data-form="'.$table['form'].'"' : '' !!} {!! array_key_exists('disable-sorting',$table) ? 'data-disable-sorting="'.$table['disable-sorting'].'"' : '' !!}>
			<thead>
				<tr>
					@foreach($table['data'] as $col_head)
					@if($col_head == 'Option')
					<th style="min-width:100px;">{!! $col_head !!}</th>
					@else
					<th>{{ $col_head }}</th>
					@endif
					@endforeach
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</div>

	<script>
		function popDeleteMessage(el){
			var form = $(el).parent().find('form');
			swal({
				title: "Are you sure you want to delete this?",
				text: "",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			}, function () {
				//delete it
				$.post(form.prop('action'), form.serialize() );
				//$(el).closest('tr').remove();
				$('.datatable').DataTable().row( $(el).closest('tr') ).remove().draw();
				swal("Deleted!", "Your imaginary file has been deleted.", "success");
			});
    	}

	</script>