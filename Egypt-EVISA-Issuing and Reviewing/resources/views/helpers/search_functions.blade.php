@section('searchscript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.dataTables.min.css') }}" />
<style type="text/css">

	table.fixed { table-layout:fixed; }

	tfoot input {
		width: 95px;
	}

	tfoot select {
		width: 95px;
	}

</style>
<script>

	var nationalities = document.createElement('select');
	var option = document.createElement('option');
	option.value = '';
	option.text = '';
	nationalities.appendChild(option);
	@foreach($nationalities as $nationality )
	option = document.createElement('option');
	option.value = '{{$nationality->country_id}}';
	option.text = '{{$nationality->description}}';
	nationalities.appendChild(option);
	@endforeach	
	
	$(document).ready(function(){
		$('#similarties').DataTable();
	});
	$.fn.dataTableExt.sErrMode = 'throw';
	$(function() {
		$('#users-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ url('/search/applications') }}",
			'language':{ 
				"loadingRecords": "&nbsp;",
				"processing": "<b> <font color = 'red' > برجاء الانتظار قليلا </font></b>"
			},
			fixedHeader: {
				header: true,
				footer: true
			},
			columns: [
			{ data: 'trav_doc_no', name: 'trav_doc_no' },
			{ data: 'nationality', name: 'description' },
			{ data: 'birthdate',  name: 'birthdate' },
			{ data: 'latin_fullname', name:'latin_fullname'},
			{ data: 'ar_fullname', name: 'ar_fullname' },
			{ data: 'application_date', name: 'application_date' },
			{ data: 'application_no', name: 'application_no' },
			],
			 "columnDefs": [
            {
                "render": function ( data, type, row ) {
                	var fun = 'viewapplication("'+data+'")' ; 
                	return "<a href='#' onclick='"+fun+"' >"+data+"</a>";
                },
                "targets": 6
            },
            
        ],initComplete: function () {
				var i = 0  ; 
				this.api().columns().every(function () {
					var column = this;
					var input;
					if(i != 1){					
						input = document.createElement("input");
					}else if(i==1) {
						input = nationalities;
					}
					
					$(input).appendTo($(column.footer()))
					.on('keyup change', function () {
						column.search($(this).val(), false, false, true).draw();
					});
					i = i + 1; 
				});

			}
		});
	});



function viewapplication(application_no){
var url =  "{{url('/search/viewapplication/application_no/')}}" +'/'+ application_no ; 
window.open(url, "_blank", "scrollbars=1,resizable=1,height=500,width=800");
}

</script>
@stop
