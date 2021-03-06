@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Edit user - تعديل المستخدم</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('users/update') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$user->id}}"/>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name- <b>الاسم</b></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ !empty(old('name'))?old('name'):$user->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email- <b>أيميل الدخول</b></label>

                            <div class="col-md-6">
                                <input id="email" type="email" readonly="true" class="form-control" name="email" value="{{ !empty(old('email'))?old('email'):$user->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password- <b>كلمة السر</b></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Password confirm- <b>تأكيد كلمة السر</b></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            
                            <label for="password-confirm" class="col-md-4 control-label"> User privileges- <b>صلاحيات المستخدم</b></label>
                            <br>
                            <table>

                            
                            @foreach($permissions as $permission)

                           
                            <tr class=" col-md-10">
                            <td ><input type="checkbox"  name="permissions[]" value="{{$permission->permission_id}}" {{ !empty($usergrants[$permission->permission_id])?$usergrants[$permission->permission_id]:'' }}  /></td>

                            <td > <b>{{$permission->permission_name}}</b></td>
                            </tr>
                           
                           
                            @endforeach

                            </table>
                    
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> حفظ التعديلات
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
