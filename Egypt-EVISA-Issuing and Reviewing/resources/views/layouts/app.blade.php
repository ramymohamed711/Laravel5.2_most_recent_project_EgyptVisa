<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Egypt EVISA - نظام التاشيرة الالكترونية</title>

    <!-- JavaScripts -->
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}" ></script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.PrintArea.js') }}"></script>

    
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.dataTables.min.css') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}"  >
    <link rel="stylesheet" href="{{ URL::asset('css/simple-sidebar.css') }}"  >

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <style>
        body {
            font-family: 'Lato';
            background-image:url('{{ URL::asset('img/bg.jpg') }}');
            background-size:     cover;    
             padding-top: 5%;             
            
        }

        .fa-btn {
            margin-right: 6px;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
          background-color: #ffd6d3;
      }

      table.dataTable tr.highlight {
    background-color: lime; 
}
  </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-fixed-top " >
        <div class="container">
            <div class="navbar-header" >

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                 Egypt VISA
             </a>
         </div>

         <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if (!Auth::guest())
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/home') }}"> <i class="glyphicon glyphicon-home" aria-hidden="true"></i><b> الرئيسية </b></a></li>
            </ul>
            
            <!-- Right Side Of Navbar -->
            <ul class="nav col-md-offset-4 navbar-nav navbar-right">
                <!-- Authentication Links -->
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/users/changepassword') }}"><i class="glyphicon glyphicon-cog"></i> <b>تغير كلمة المرور</b></a></li>
                        <li><a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out"></i> <b>تسجيل خروج</b></a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable();
} );
</script>


@yield('content')
<!--dates functions  JavaScripts -->
@yield('datescript')
<!-- search functions  -->
@yield('searchscript')


</body>
</html>
