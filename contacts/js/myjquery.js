$(function () {
// Dialog Open	 add books
$("#selectfile").dialog({
    autoOpen: false,
    height: 'auto',
    width: 'auto',
    modal: true,
	closeOnEscape:true, 
	resizable:false, 
	show:'fade',
    buttons: { 
	"Ok": function() { $(this).dialog("close"); } 
    }
});


$("#d2").dialog({
    autoOpen: false,
    height: 'auto',
    width: 'auto',
    modal: true,
	closeOnEscape:true, 
	resizable:false, 
	show:'fade',
    buttons: { 
      "Ok": function() { $(this).dialog("close"); } 
    }
});

$("#d3").dialog({
    autoOpen: false,
    height: 'auto',
    width: 'auto',
    modal: true,
	closeOnEscape:true, 
	resizable:false, 
	show:'fade',
    buttons: { 
      "Ok": function() { $(this).dialog("close"); } 
    }
});

$("#popadd").click(function(){
    $("#selectfile").dialog("open");
});
});