@extends('layouts.app')

@section('content')
@include('checkingofficer.siderbar')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/checkingofficer/handelsearch') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('application_no') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Application number - <b>رقم الطلب </b></label>

                            <div class="col-md-6">
                                <input id="application_no" type="text" class="form-control" name="application_no" value="">

                                @if ($errors->has('application_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('application_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    

                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-search"></i> بحث
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
