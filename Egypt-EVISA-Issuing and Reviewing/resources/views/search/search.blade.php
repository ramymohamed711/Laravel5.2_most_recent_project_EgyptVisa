@extends('layouts.app')
@include('helpers.search_functions')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">البحث فى الطبات</div>
				<div class="panel-body">
					<table class=" hover fixed cell-border display"  id="users-table" >
						<thead>
							<tr>
								<th>رقم وثيقة الدخول</th>
								<th>الجنسية</th>
								<th>تاريخ الميلاد</th>
								<th>الاسم الاتيني</th>
								<th>الاسم العربى</th>
								<th> تاريخ تقديم الطلب </th>
								<th>رقم الطلب </th>
							</tr>
							
						</thead>

							<tfoot>
							<tr>
								<th>رقم وثيقة الدخول</th>
								<th>الجنسية</th>
								<th>تاريخ الميلاد</th>
								<th>الااسم الاتيني</th>
								<th>الااسم العربى</th>
								<th> تاريخ تقديم الطلب </th>
								<th>رقم الطلب </th>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@stop



