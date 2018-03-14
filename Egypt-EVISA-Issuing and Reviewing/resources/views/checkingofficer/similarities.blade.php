  
@extends('layouts.app')

@section('content')

@include('checkingofficer.siderbar')

@include('helpers.chk_functions')
<div class="container">
  <div class="row">
    <div class="col-md-12 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading text-right"><b>Application similarities - تشابهات الطلب </b></div>
        <div class="panel-body" >
          @if(empty($application))
          <h4 class="pull-right">لا يوجد طلبات للمراجعة الان </h4>
          @else
          <a href='#' class="btn pull-right  btn-info   btn-md col-md-2 col-md-offset-1" onclick="chk_off_printapplication('{{$application->application_no}}')"> <i class="glyphicon glyphicon-print"></i> <b>طباعة الطلب </b> 
          </a> 
          
          <div id="application">

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
              </tbody>
            </table>

            <table  class="display nowrap"  id="datatable">
              <thead>
                <tr class="row">
                  <th></th>
                  <th>الجنسية</th>
                  <th>تاريخ الميلاد </th>
                  <th>الاسم </th>
                  <th>#</th>
                </tr>
                
              </thead>
               <tfoot>
                <tr class="row">
                  <th></th>
                  <th>الجنسية</th>
                  <th>تاريخ الميلاد </th>
                  <th>الاسم </th>
                  <th>#</th>
                </tr>
                
              </tfoot>
              <tbody>

                @foreach($similarities as $similarity)


                <tr class="bg-warning row row_ref_{{$similarity['main_person_id']}}" name="row"  id="row_{{$similarity['main_person_id']}}">
                  
                  <th> 
                  <div class="bg-info details table_{{$similarity['main_person_id']}}">
                  <table style=" width: 50%; margin: auto;float: none;">
                  <tr class="row row_{{$similarity['main_person_id']}}">
                  <th></th>
                  <th>الرقم الالى</th>
                  <th>نوع الادراج</th>
                  <th>جهة الادراج</th>

                </tr>
                @for($i = 0 ; $i < sizeof($similarity['enrollment_requester']) ; $i++ )               
                <tr class="row row_{{$similarity['main_person_id']}}">
                  <th></th>
                  <th>{{$similarity['main_person_id']}}</th>
                  <th>{{$similarity['enrollment_action'][$i]}}</th>
                  <th>{{$similarity['enrollment_requester'][$i]}}</th>
                </tr>
                @endfor
                </table>
                </div>
                   </th> 
                  
                  <th>{{$similarity['nationality']}}</th>
                  <th>{{$similarity['birthdate']}}</th>
                  <th>{{$similarity['name']}}</th>
                  <th>{{$similarity['main_person_id']}} <input type="radio" onclick='heightlight({{$similarity['main_person_id']}})' name="enrollment" value="{{$similarity['main_person_id']}}"></th>
                  

                </tr>

                
                @endforeach
              </tbody>
            </table>


          </div>
          <br>
          <div class="col-md-10 col-md-offset-1">

           <a href="#" onclick="chk_off_sendnationalsecurity('{{$application->application_no}}')" class="btn 
             btn-primary btn-md col-md-2 "> <i class="glyphicon glyphicon-send"></i> <b> أمن وطنى</b> 
           </a>    



           <a href="#" onclick="chk_off_sendcontact('{{$application->application_no}}')" class="btn btn-primary btn-md col-md-2 col-md-offset-1 "> <i class="glyphicon glyphicon-send"></i> <b>ضابط اتصال
           </a> 



           <a href="#" onclick="chk_off_sendnationalandcontact('{{$application->application_no}}')" class="btn btn-primary  btn-md col-md-3 col-md-offset-1"> <i class="glyphicon glyphicon-send"></i> <b>امن وطنى و ضابط اتصال</b> 
           </a> 

           <a href="#" onclick="chk_off_negative('{{$application->application_no}}')" class="btn btn-primary  btn-md col-md-2 col-md-offset-1 "> <i class="glyphicon glyphicon-send"></i> <b>بت سلبى</b> 
           </a> 




         </div>
         @endif
       </div>
     </div>
   </div>
 </div>
</div>

@endsection
