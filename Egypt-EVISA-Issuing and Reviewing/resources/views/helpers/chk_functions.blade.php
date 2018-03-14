<script>
 function chk_off_printapplication(application_no){
  if (confirm('هل تريد طباعة الطلب ؟  ')) {

    $.ajax({
      type: 'POST',
      url: "{{url('/checkingofficer/printapplication')}}",
      data: {application_no:application_no , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        printcontent("application");
        if(resultData=="success"){
          alert("قد تم حفظ الطلب بنجاح ");
        }
      }
    });

  }

}

function printcontent(id){

 var mode = 'iframe'; // popup
 var close = mode == "popup";
 var options = { mode : mode, popClose : close};
 $("#"+id).printArea( options );
 setTimeout(function(){
    window.location.replace("{{url('/checkingofficer/applications')}}");
 }, 1000);

 return true ;
}



/* Send to contact officer */
function chk_off_sendcontact(application_no){
  if (confirm('هل تريد ارسال الطلب لضابط الاتصال ؟  ')) {
    var enrollment = $('input[name="enrollment"]:checked').val();
    $.ajax({
      type: 'POST',
      url: "{{url('/checkingofficer/sendtocontactofficer')}}",
      data: {application_no:application_no , main_person_id:enrollment ,  _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
          window.location.replace("{{url('/checkingofficer/applications')}}");
        }else {
          alert("حدث خطاء ما يرجى التاكد من اختيار الادراج");
        }
      }
    });
    
  }

}

/*Send to national security officer */
function chk_off_sendnationalsecurity(application_no){

  if (confirm('هل تريد ارسال الطلب للامن الوطنى ؟ ')) {
    var enrollment = $('input[name="enrollment"]:checked').val();
    $.ajax({
      type: 'POST',
      url: "{{url('/checkingofficer/sendtonationalsecurity')}}",
      data: {application_no:application_no , main_person_id:enrollment ,_token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
          window.location.replace("{{url('/checkingofficer/applications')}}");
        }
        else {
          alert("حدث خطاء ما يرجى التاكد من اختيار الادراج");
        }
      }
    });
  }

}

/*Send to national security and contact officer */
function chk_off_sendnationalandcontact(application_no){
  if (confirm('هل تريد ارسال الطلب لضابط الاتصال و للامن الوطنى ؟ ')) {
    var enrollment = $('input[name="enrollment"]:checked').val();
    $.ajax({
      type: 'POST',
      url: "{{url('/checkingofficer/sendtonationalandcontact')}}",
      data: {application_no:application_no , main_person_id:enrollment ,_token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
         window.location.replace("{{url('/checkingofficer/applications')}}");
       }
       else {
          alert("حدث خطاء ما يرجى التاكد من اختيار الادراج");
        }
     }
   });
  }

}

/*Negative similarities */
function chk_off_negative(application_no){
  if (confirm('تاكيد البت السلبى ')) {
    $.ajax({
      type: 'POST',
      url: "{{url('/checkingofficer/negativesimilarities')}}",
      data: {application_no:application_no , _token:"{{csrf_token()}}" },
      dataType: "text",
      success: function(resultData) { 
        if(resultData=="success"){
         window.location.replace("{{url('/checkingofficer/applications')}}");
       }
     }
   });
  }

}


function heightlight(row_id){

 $('.details').each(function() {
  $(this).removeClass('bg-info'); 
  $(this).removeClass('bg-danger');
});

 $('.details').each(function() {
  $(this).addClass('bg-info'); 
});

 $('.table_'+row_id).each(function() {
  $(this).addClass('bg-danger'); 
});

 $("#table_"+row_id).addClass('bg-danger'); 

}


</script>
