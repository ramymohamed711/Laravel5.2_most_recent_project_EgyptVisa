<script>
 function sec_off_printapplication(application_no){
  if (confirm('هل تريد طباعة الطلب ؟  ')) {
    
   var url =  "{{url('/nationalsecurity/printapplication/application_no/')}}" +'/'+ application_no ; 
    window.location.replace(url);

  }

}

function sec_get_similarties(application_no){
 var url =  "{{url('/nationalsecurity/getsimilarities/application_no/')}}" +'/'+ application_no ; 
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
function sec_off_approval(application_no){
  if (confirm('تاكيد الموافقه على تصريح دخول هذا الطلب ؟')) {
    
    $.ajax({
      type: 'POST',
      url: "{{url('/nationalsecurity/acceptapplication')}}",
      data: {application_no:application_no , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
          alert("قد تم حفظ الطلب بنجاح ");
          window.location.replace("{{url('/nationalsecurity/search')}}");
       }
     }
   });

  }
}


/*Contact officer reject application*/
function sec_off_rejection(application_no){
   if (confirm('تاكيد الموافقه على رفض تصريح هذا الطلب ؟')) {
    
    $.ajax({
      type: 'POST',
      url: "{{url('/nationalsecurity/rejectapplication')}}",
      data: {application_no:application_no , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
          alert("قد تم حفظ الطلب بنجاح ");
          window.location.replace("{{url('/nationalsecurity/search')}}");
       }
     }
   });

  }
}





</script>
