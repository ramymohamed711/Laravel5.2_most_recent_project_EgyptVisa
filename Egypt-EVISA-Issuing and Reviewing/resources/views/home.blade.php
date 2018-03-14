@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body text-center">
                       @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                   
                @foreach (Session::get('grants') as $grant=>$permission)
                @if($permission['menu']==1)
        <div class="col-md-2 col-md-offset-5">
            
        <a href='{{ url("") }}/{{$permission["link"]}}' class="btn-block  btn btn-primary waves-light "> <b>{{ $permission['name']  }} </b> 
        </a>    
        
        </div>
        
        
        
        <br><br><br>
            @endif
                @endforeach
            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
