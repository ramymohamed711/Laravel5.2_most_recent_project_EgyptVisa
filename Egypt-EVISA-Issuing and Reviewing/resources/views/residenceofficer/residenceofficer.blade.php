
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body text-center">
                     
                   
               
        <div class="col-md-2  col-md-offset-5">
            
        <a href='{{ url("residenceofficer/applications") }}' class="btn-block  btn btn-primary waves-light "> <b>مراجعة الطلبات</b> 
        </a>    
        
        </div>
        
           <br><br><br>
         <div class="col-md-2 col-md-offset-5">
            
        <a href='{{ url("residenceofficer/search") }}' class="btn-block  btn btn-primary waves-light "> <b>البحث برقم الطلب</b> 
        </a>    
        
        </div>

          <br>
                    <br>
                    <br>
                    <div class="col-md-2 col-md-offset-5">

                        <a href='{{ url("residenceofficer/loadprinted") }}' class="btn-block  btn btn-primary waves-light "> <b>اعادة طباعة الطبات</b> 
                        </a>    

                    </div>
        
        
     
          
            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
