
function loadCalendar(events){
   if($("#bbit-cs-buddle").length >0)
    {
        $("#bbit-cs-buddle").hide();
    }
}

    $("#caltoolbar").noSelect();

    $("#hdtxtshow").datepicker({picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
        onReturn: function(r) {
            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        }
    });
    
    $("#showreflashbtn").click(function(e) {
        $("#gridcontainer").reload();
    });

   