@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"> 
				<div class="panel-body">
			  <table class="table">
              <thead>
                <tr>

                  <th>الجنسية</th>
                  <th>تاريخ الميلاد </th>
                  <th>الاسم اللاتيني</th>
                  <th>الاسم العربى</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <tr class="active">
                  <td>{{$application->getnationality->description}}</td>
                  <td>{{$application->birthdate}}</td>
                  <td>{{$application->latin_fullname}}</td>
                  <td>{{$application->ar_fullname}}</td>
                  <td>{{$application->application_no}}</td>
                </tr>
                </tbody>
             </table>

             <table class="table">
             	<thead>
             		<tr>
             		<th> المسؤل الحالى </th>
             		<th>القرار المتخذ</th>
             		<th>تاريخ المراجعة</th>
             		<th>المراجع</th>
             		</tr>
             	</thead>
             	<tbody>
             		
             		@foreach($logs as $log)
             		<tr>
             		<td>{{ !empty($log->getactionuser->name)?$log->getactionuser->name:'---'}} </td>
             		<td>{{$log->getstatus->appstatus_name}} </td>
             		<td>{{$log->log_date}} </td>
             		<td>{{$log->getuser->name}} </td>


             		
             		</tr>
             		@endforeach
             	
             	</tbody>
             </table>

				</div>
			</div>
		</div>
	</div>
</div>

@stop



