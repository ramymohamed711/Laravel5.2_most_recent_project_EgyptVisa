@extends('layouts.app')
@section('content')
@include('helpers.con_functions')


<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading text-right"><b>Application similarities - تشابهات الطلب </b></div>
        <div class="panel-body" >
          @if(empty($applications))
          <h4 class="pull-right">لا يمكن عرض هذا الطلب </h4>
          @else
          
          <div id="application">

            @foreach($applications aS $application)
            <div id="app_{{$application->application_no}}"  style="height:700px;">
             <center> 
              <img  src="data:image/png;base64,{{$application->barcode}}" />
            </center>   
            <span class="help-block">            
            </span>

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



                <tr class='bg-warning'>
                  <td>{{$application['similarities']['nationality']}}</td>
                  <td>{{$application['similarities']['birthDate']}}</td>
                  <td>{{$application['similarities']['mainNameEn']}}</td>
                  <td>{{!empty($application['similarities']['mainNameAr'])?$application['similarities']['mainNameAr']:'---'}}</td>
                  <td>{{$application['similarities']['main_person_id']}}</td>
                </tr>

                <tr class="">

                  <th>تاريخ الادراج</th>
                  <th>رقم النشرة</th>
                  <th>الرقم الالى</th>
                  <th>نوع الادراج</th>
                  <th>جهة الادراج</th>

                </tr>
                @foreach($application['similarities']['actions'] as $action)


                <tr class="">
                  <td> {{$action[4]}}</td>
                  <td> {{$action[5]}}</td>
                  <td> {{$application['similarities']['main_person_id']}}</td>
                  <td> {{$action[2]}} </td>
                  <td> {{$action[1]}} </td>
                </tr>

                @endforeach

              </tbody>
            </table>
            <span class="help-block">

            </span>
            </div>
            @endforeach
          
        </div>


        @endif
      </div>
    </div>
  </div>
</div>
</div>
@if(!empty($print))
<script>
  printcontent();
</script>

@endif
@endsection
