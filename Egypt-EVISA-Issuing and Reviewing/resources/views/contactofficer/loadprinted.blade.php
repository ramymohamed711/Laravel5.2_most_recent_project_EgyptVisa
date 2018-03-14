@extends('layouts.app')

@section('content')

@include('helpers.dates_functions')
@include('contactofficer.siderbar')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/contactofficer/printagain') }}">
                        {{ csrf_field() }}



                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Date - <b>التاريخ </b></label>
                            <input type="hidden" id="from-date" name="from_date" value="">
                            <input type="hidden" id="to-date"   name="to_date" value="">
                            <div class="col-md-6">
                             <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> <b class="caret"></b>
                          </div> 

                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-print"></i> اعادة طباعة
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
