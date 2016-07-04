$("button#submit").click( function() {
 
  if( $("#username").val() == "" || $("#password").val() == "" )
    $("div#show").html("Please enter both username and password");
  else
    $.post( $("#myForm").attr("action"),
	        $("#myForm :input").serializeArray(),
			function(data) {
			  $("div#show").html(data);
			});
 
	$("#myForm").submit( function() {
	   return false;	
	});
 
});