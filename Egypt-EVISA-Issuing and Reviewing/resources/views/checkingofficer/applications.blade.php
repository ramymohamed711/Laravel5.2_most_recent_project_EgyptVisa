@include('helpers.chk_functions')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-right"><b>Application detials - بيانات الطلب </b></div>
                <div class="panel-body" >
                    @if(empty($application))
                    <h4 class="pull-right">لا يوجد طلبات للمراجعة الان </h4>
                    @else
                   <div id="application">
                    <div class="form-group" dir="rtl">
                        <label for="email" class="col-md-3 control-label pull-right">رقم الطلب</label>
                        <div class="col-md-7 col-md-offset-5" >
                            <div  class="form-control">
                                {{$application->application_no}}
                            </div>
                            
                            <span class="help-block">
                                
                            </span>
                            
                        </div>
                    </div>
                    @if($application->ar_fullname)
                    <div class="form-group" dir="rtl">
                        <label for="email" class="col-md-3 control-label pull-right"> الاسم العربى</label>
                        <div class="col-md-7 col-md-offset-5" >
                         <div  class="form-control">
                            {{$application->ar_fullname}}
                        </div>
                        
                        <span class="help-block">
                            
                        </span>
                    </div>
                </div>
                @endif

                <div class="form-group" dir="rtl">
                    <label for="email" class="col-md-3 control-label pull-right"> الاسم الاجنبي</label>
                    <div class="col-md-7 col-md-offset-5" >
                     <div  class="form-control">
                        {{$application->latin_fullname}}
                    </div>
                    
                    <span class="help-block">
                        
                    </span>
                </div>
            </div>

            <div class="form-group" dir="rtl">
                <label for="email" class="col-md-3 control-label pull-right"> تاريخ الميلاد</label>
                <div class="col-md-7 col-md-offset-5" >
                    <div  class="form-control">
                        {{ date('Y/m/d', strtotime($application->birthdate))}}
                    </div>
                    
                    <span class="help-block">
                        
                    </span>
                </div>
            </div>

            <div class="form-group" dir="rtl">
                <label for="email" class="col-md-3 control-label pull-right"> رقم جواز السفر</label>
                <div class="col-md-7 col-md-offset-5" >
                    <div  class="form-control">
                        {{$application->TRAV_DOC_NO}}
                    </div>
                    
                    <span class="help-block">
                        
                    </span>
                </div>
            </div>

            <div class="form-group" dir="rtl">
                <label for="email" class="col-md-3 control-label pull-right"> الجنسية</label>
                <div class="col-md-7 col-md-offset-5" >
                    <div  class="form-control">
                        {{$application->getnationality->description}}
                    </div>
                    
                    <span class="help-block">
                        
                    </span>
                </div>
            </div>
            </div>

            <div class="col-md-7 col-md-offset-3 ">
              <a href="{{url('/checkingofficer/getsimilarities/application_no/')}}/{{$application->application_no}}" class="btn btn-default btn-primary btn-md col-md-4 col-md-offset-1"> <i class="glyphicon glyphicon-search"></i> <b>عرض التشابهات </b> 
              </a>    
              
              <a href='#' class="btn btn-default btn-info btn-md col-md-4 col-md-offset-1" onclick="chk_off_printapplication('{{$application->application_no}}')"> <i class="glyphicon glyphicon-print"></i> <b>طباعة الطلب </b> 
              </a>  

          </div>


          @endif

          
          
      </div>
  </div>
</div>
</div>
</div>
@endsection
