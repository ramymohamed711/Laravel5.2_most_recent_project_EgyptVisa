@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body text-right ">
                 <h4 > ليس لديك اى صلاحية لاستخدام هذه الصفحه   </h4> 
                  <b> <a href="{{url('/home')}}"> الرجوع للرئيسية </a> </b>



             </div>
         </div>
     </div>
 </div>
</div>
@endsection
