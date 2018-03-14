<script>
 function con_off_printapplication(application_no){
  if (confirm('هل تريد طباعة الطلب ؟  ')) {

    var url =  "{{url('/contactofficer/printapplication/application_no/')}}" +'/'+ application_no ; 
    window.location.replace(url);
  }

}


function con_get_similarties(application_no){
 var url =  "{{url('/contactofficer/getsimilarities/application_no/')}}" +'/'+ application_no ; 
window.open(url, "_blank", "scrollbars=1,resizable=1,height=500,width=800");
}


function printcontent(){
 var mode = 'iframe'; // popup
 var close = mode == "popup";
 var options = { mode : mode, popClose : close};
 
 $("#application").printArea( options );
 setTimeout(function(){
  var referrer =  document.referrer;
  window.location.replace(referrer);
 }, 1000);
 
 return true;
}


/*Contact officer accept  application*/
function con_off_approval(application_no){
  if (confirm('تاكيد الموافقه على تصريح دخول هذا الطلب ؟')) {

    $.ajax({
      type: 'POST',
      url: "{{url('/contactofficer/acceptapplication')}}",
      data: {application_no:application_no , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        printcontent("application");
        if(resultData=="success"){
          alert("قد تم حفظ الطلب بنجاح ");
          window.location.replace("{{url('/contactofficer/search')}}");
        }
      }
    });

  }
}


/*Contact officer reject application*/
function con_off_rejection(application_no){
 if (confirm('تاكيد الموافقه على رفض تصريح هذا الطلب ؟')) {

  $.ajax({
    type: 'POST',
    url: "{{url('/contactofficer/rejectapplication')}}",
    data: {application_no:application_no , _token:"{{csrf_token()}}" },
    dataType: "text",
    success: function(resultData) { 
      printcontent("application");
      if(resultData=="success"){
        alert("قد تم حفظ الطلب بنجاح ");
        window.location.replace("{{url('/contactofficer/search')}}");
      }
    }
  });

}
}





</script>
