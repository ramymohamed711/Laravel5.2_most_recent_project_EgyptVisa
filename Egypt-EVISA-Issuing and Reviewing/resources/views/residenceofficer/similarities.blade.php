  
@extends('layouts.app')
@section('content')

@include('helpers.res_functions')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading text-right"><b>Application similarities - تشابهات الطلب </b></div>
        <div class="panel-body" >
          @if(empty($application))
          <h4 class="pull-right">لا يمكن عرض هذا الطلب </h4>
          @else

          <div id="application">
            <center> 
              <img  src="data:image/png;base64,{{$application->barcode}}" />
            </center>   
            <span class="help-block">            
            </span>
            <table class="table">
              <thead>
                <tr>

                  <th >الجنسية</th>
                  <th >تاريخ الميلاد </th>
                  <th >الاسم اللاتيني</th>
                  <th >الاسم العربى</th>
                  <th >#</th>
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




                <tr class='bg-warning '>
                  <td>{{$similarities['nationality']}}</td>
                  <td>{{$similarities['birthDate']}}</td>
                  <td>{{$similarities['mainNameEn']}}</td>
                  <td>{{!empty($similarities['mainNameAr'])?$similarities['mainNameAr']:'---'}}</td>
                  <td>{{$similarities['main_person_id']}}</td>
                </tr>

                <tr >

                  <th >تاريخ الادراج</th>
                  <th >رقم النشرة</th>
                  <th >الرقم الالى</th>
                  <th>نوع الادراج</th>
                  <th >جهة الادراج</th>

                </tr>
                @foreach($similarities['actions'] as $action)


                <tr>
                  <td>{{$action[4]}}</td>
                  <td> {{$action[5]}}</td>
                  <td>{{$similarities['main_person_id']}}</td>
                  <td> {{$action[2]}} </td>
                  <td> {{$action[1]}} </td>
                </tr>

                @endforeach


              </tbody>
            </table>

            @if(!empty($log))
            <table class="table ">
              <thead  class="text-right">
                <tr >
                <th class="text-right"> بتاريخ</th>
                <th class="text-right"> بواسطة</th>
                <th class="text-right"> القرار</th>
                </tr>
              </thead>
              <tbody>
                @foreach($log as $details)
                  <tr class="text-right">
                    <td>{{$details[2]}}</td>
                    <td>{{$details[0]}}</td>
                    <td>{{$details[1]}}</td>
                  </tr>                
                @endforeach
              </tbody>
            </table>
            @endif
            @if(!empty($search))
            <div class="col-md-12 col-md-offset-1">

             <a href="#" onclick="res_off_approval('{{$application->application_no}}')" class="btn 
               btn-primary btn-md col-md-2 col-md-offset-2"> <i class="glyphicon glyphicon-ok"></i> <b>تصريح دخول</b> 
             </a>    

             <a href="#" onclick="res_off_rejection('{{$application->application_no}}')" class="btn btn-primary btn-md col-md-2 col-md-offset-2 "> <i class="glyphicon glyphicon-remove"></i> <b>عدم تصريح الدخول</b>
             </a> 


           </div>
           @endif
         </div>

         
         @endif
       </div>
     </div>
   </div>
 </div>
</div>
@endsection
