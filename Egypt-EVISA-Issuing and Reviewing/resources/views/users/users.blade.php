@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                 
                   <div class="col-md-2 col-md-offset-5 pull-right">
          <a href='{{ url("users/create")}}' class="btn-block btn btn-info waves-light "> <i class="glyphicon glyphicon-plus-sign left"></i> <b>أضافة مستخدم </b> 
        </a>    
        
        </div>

      <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>الاسم</th>
          <th>ألايميل</th>
          <th style="width: 100px;"></th>
        </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr id="row-{{$user->id}}">
          <td>{{$user->id}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->email}}</td>
          <td>
              <a href="{{url('/users/edit/id')}}/{{$user->id}}" ><i class=" col-xs-3 glyphicon glyphicon-pencil"></i>  </a> 
              <a href="#" onclick="suspend({{$user->id}})"><i class="col-xs-3 glyphicon glyphicon-remove"></i>  </a>
          </td>
        </tr>
      @endforeach
      </tbody>
      </table>
                


                </div>
            </div>
        </div>
    </div>
</div>

<script>
  function suspend(user_id){
  if (confirm('هل انت متاكد من حذف هذا المستخدم ؟ ')) {
  $.ajax({
      type: 'POST',
      url: "{{url('/users/suspend')}}",
      data: {id:user_id , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
          $('#row-'+user_id).remove();
        }
      }
});
}

  }

</script>

@endsection
