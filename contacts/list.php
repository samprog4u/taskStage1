<?php
	session_start();
	//Generating tokens agains CSRF attack
	$token= md5(uniqid());
	$_SESSION['update_contact_token']= $token;
	include("header.php");
	//including my connection and database channels only
	include_once("connect/dbconnect.php");
	$contact=new ContactList;
?>
<script type="text/javascript">
	$(function() {
		//openning a popup dialog box for updating
	    $(".button").click(function() {
	        $("#myform #valueFromMyButton").text($(this).val().trim());
	        $("#myform input[type=text]").val('');
	        //retrieve edited value using jquery post ajax using json
	        var id = event.target.id;
	        var dataString = 'id='+ id;
	        $.ajax({
	        	type: "POST",
				url: "get_record",
				data:dataString,
				dataType: "json",
				cache:false,
				success: function(data){
					try 
					{
						myData = data;
						if(myData == "0")
						{
							alert("You may have alter this document with a developer tools...");
							$("#myform").hide(400);
							return false;
						}
						for(var result in myData)
						{
							$("#_token_id").val(myData[result][0].trim());
							$("#fullname").val(myData[result][1].trim());
							$("#email").val(myData[result][2].trim());
						}
					} catch (e) {
						alert("Err: "+e);
					}
				},
				error:function (xhr, status, err){
					alert("Error: "+xhr.responseText);
				}
			})
	        //end retrieve
	        $("#myform").show(500);
	    });
		//closing the pop up that update
	    $("#btnclose").click(function() {
	    	var msg_name = document.getElementById('form_name_errorloc');
			var msg_email = document.getElementById('form_email_errorloc');
			msg_name.innerHTML = "";
			msg_email.innerHTML = "";
	        $("#valueFromMyModal").val($("#myform input[type=text]").val().trim());
	        $("#myform").hide(400);
	    });
	});
</script>
<script type="text/javascript">
function validate()
{
	//Validating client side inputs and specifically for a valid inputs
	var obj_fullname = document.getElementById('fullname');
	var obj_email = document.getElementById('email');
	var msg_name = document.getElementById('form_name_errorloc');
	var msg_email = document.getElementById('form_email_errorloc');
	
	if(obj_fullname.value == "")
	{
		msg_name.innerHTML="Please names is required!";
		obj_fullname.focus();
		return false;
	}
	else
	{
		msg_name.innerHTML = "";
	}

	if(obj_email.value == "")
	{
		msg_email.innerHTML="Please email address is required!";
		obj_email.focus();
		return false;
	}
	else
	{
		msg_email.innerHTML = "";
	}

	var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
	if(!re.test(obj_email.value))
	{
		msg_email.innerHTML="Please a valid email address is required!";
		obj_email.focus();
		return false;
	}
	else
	{
		msg_email.innerHTML = "";
	}
}
</script>
<div id="container3">
	<div class="form_head" align="center">List of email contacts</div>
		<!-- Dialog Box-->
	    <div class="dialog" id="myform">
	      <div class="form_head" align="center">Update contact list</div>
	      <form method="post" action="update_process" onsubmit="return validate();">
	      		<input type="hidden" name="_token" value="<?php echo $validator->noHTML($token); ?>" />
	        	<label class="control-label">Names :</label>
				<div class="controls">
					<div id='form_name_errorloc' class="error_strings"></div>
					<input type="text" name="fullname" placeholder="Enter your name (Surname first)" required id="fullname" class="form-control" />
				</div>
				<label class="control-label">Email Address :</label>
				<div class="controls">
					<div id='form_email_errorloc' class="error_strings"></div>
					<input type="text" name="email" placeholder="Enter your email" id="email" required class="form-control" />
				</div>
				<div class="controls" align="center">
					<button id="" type="submit" name="submit" value="Update" class="btn btn-primary">Update</button>
					<button id="btnclose" type="button" class="btn btn-info">Close</button>
				</div>
				<input type="hidden" name="_token_id" id="_token_id" />
	      </form>
	    </div>
	    <div class="<?php echo $validator->noHTML(@$_SESSION['mtype']); ?>" align="center"><?php echo $validator->noHTML(@$_SESSION['msg']); ?></div>
		<div class="control-group">
		    <table name="booklist" id="dtable" width="900">
				<thead>
					<th>ID</th>
					<th>Names</th>
					<th>Email</th>
					<th>Date Created</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php
					$result = $contact->SelectDB('contact_book', '*');
					foreach ($result as $results) 
					{
					 	$id = $results['id'];
					 	$names = $results['names'];
					 	$email = $results['email'];
					 	$date_created = $results['time'];
						echo "<tr class='tb1'>";
						echo "<td >" . $validator->noHTML($id) . "</td>";
						echo "<td style='text-align:left;'>" . $validator->noHTML($names) . "</td>";
						echo "<td style='text-align:left;'>" . $validator->noHTML($email) . "</td>";
						echo "<td style='text-align:left;'>" . date('d-m-Y h:i:s A', $validator->noHTML($date_created)) . "</td>";
						echo "<td style='text-align:left;'><a style='cursor:pointer;' id='" . $validator->noHTML($id) . "' class='button'>Edit</td>";
						echo "</tr>";
					}
				?>
				<tbody>
			</table>
		</div>
</div>
<?php
	unset($_SESSION['msg']);
	unset($_SESSION['mtype']);
?>
</body>
</html>