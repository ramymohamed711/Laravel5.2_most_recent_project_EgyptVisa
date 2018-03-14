@section('datescript')
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/datepicker.css')}}">
@stop

<script type="text/javascript">
    $(document).ready(function () {
        $('#date').datepicker({
            format: "dd/mm/yyyy"
        });  

    });
    $(function() {


        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#from-date').val(start.format('D/MM/YYYY'));
            $('#to-date').val(end.format('D/MM/YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate:moment(),
            ranges: {
             'اليوم': [moment(), moment()],
             'امس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'اخر 7 ايام': [moment().subtract(6, 'days'), moment()],
             'اخر 30 يوم': [moment().subtract(29, 'days'), moment()],
             'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
             'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         },
         "locale": {
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "تـأكيد",
            "cancelLabel": "الغــاء",
            "fromLabel": "من",
            "toLabel": "ألــى",
            "customRangeLabel": "مخصص",
            "daysOfWeek": [
            "اح",
            "اث",
            "ثل",
            "ار",
            "خم",
            "جم",
            "سب",
            ],
            "monthNames": [
            "يناير",
            "فيبراير",
            "مارس",
            "ابريل",
            "مايو",
            "يونيو",
            "يوليو",
            "اغسطس",
            "سيبتمبر",
            "اكتوبر",
            "نوفمبر",
            "ديسبمر"
            ],
            "firstDay": 6,
            
        }

    }, cb);
        cb(start, end);
    });
</script>
