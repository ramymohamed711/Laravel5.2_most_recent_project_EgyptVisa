@extends('layouts.app')
@include('helpers.sec_functions')

@section('content')
@include('nationalsecurity.siderbar')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-right"><b>Applications under review - طلبات تحت الفحص </b></div>
                <div class="panel-body">
                    @if(empty($numbers))
                    <h4 class="pull-right">لا يوجد طلبات للمراجعة الان </h4>
                    @else
                   
                    <div id="application">
                        <table class="table table-striped table-hover"> 
                           <thead>
                            <tr>
                                <th> </th>
                                <th> </th>
                                <th class="text-right"> تاريخ الطلب </th>
                                <th class="text-right"> الجنسية </th>
                                <th class="text-right"> تاريخ الميلاد </th>
                                <th class="text-right"> الاسم اللاتيني </th>
                                <th class="text-right"> الاسم العربي </th>
                                <th class="text-right"> رقم الطلب </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                            <tr id="row_{{$application->details->application_no}}" > 
                            <td><a  onclick="sec_get_similarties('{{$application->details->application_no}}')" href="#"><i class="glyphicon glyphicon-user"> </i></a> </td>
                            <td ><a href='#' onclick="sec_off_printapplication('{{base64_encode(urlencode($application->details->application_no))}}')"><i class="glyphicon glyphicon-print"></i></a></td>
                                <td class="text-right">{{ date('Y/m/d', strtotime($application->details->creation_date))}} </td>
                                <td class="text-right">{{$application->details->getnationality->description}} </td>
                                <td class="text-right">{{ date('Y/m/d', strtotime($application->details->birthdate))}} </td>
                                <td class="text-right">{{$application->details->latin_fullname}} </td>
                                <td class="text-right">@if(!empty($application->details->ar_fullname)) {{$application->details->ar_fullname}} @else -- @endif </td>
                                <td class="text-right">{{$application->details->application_no}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $applications->appends(Request::only(['from_date'=>'from_date','to_date'=>'to_date']))->render() !!} 



                    <div class="col-md-8 col-md-offset-4 ">
                      <a href='#' class="btn btn-default btn-primary btn-md col-md-2 col-md-offset-2" onclick="sec_off_printapplication('{{$numbers}}')"> <i class="glyphicon glyphicon-print"></i>  <b>اعادة الطباعة  </b> 
                      </a>  

                  </div>
              </div>

              @endif



          </div>
      </div>
  </div>
</div>
</div>
@endsection
