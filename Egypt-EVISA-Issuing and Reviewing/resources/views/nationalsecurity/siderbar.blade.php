<div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                 مهام ضابط الامن الوطني
                </a>
            </li>
            <li>
                <a href="{{url('/nationalsecurity/applications')}}"><i class="glyphicon glyphicon-file"></i> <b> مراجعة الطلبات </b></a>
            </li>
            <li>
                <a href="{{url('/nationalsecurity/search')}}"><i class="glyphicon glyphicon-search" ></i> <b> البحث برقم الطلب </b></a>
            </li>
            <li>
                <a href="{{url('/nationalsecurity/loadprinted')}}"><i class="glyphicon glyphicon-print" ></i> <b> اعادة طباعة الطلبات </b></a>
            </li>
          
            <li>
                <a href="{{ url('/users/changepassword') }}"><i class="glyphicon glyphicon-cog" ></i> <b> تغير كلمة المرور </b></a>
            </li>
            <li>
                <a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out" ></i> <b>تسجيل خروج </b></a>
            </li>
        </ul>
    </div>
</div>
