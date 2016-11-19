<?php
	session_start();
	//Generating tokens agains CSRF attack
	$token= md5(uniqid());
	$_SESSION['add_contact_token']= $token;
	include("header.php");
?>
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
<div id="container">
	<div class="form_head" align="center">Add new contact</div><br>
	<div class="<?php echo $validator->noHTML(@$_SESSION['mtype']); ?>" align="center"><?php echo $validator->noHTML(@$_SESSION['msg']); ?></div>
	<form method="post" action="add_process" onsubmit="return validate();">
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
		<div class="controls">
			<button id="btn" type="submit" name="submit" value="Save" class="btn btn-primary">Save</button>
			<button id="btnc" type="reset" class="btn btn-info">Reset</button>
		</div>
	</form>
</div>
<?php
	unset($_SESSION['msg']);
	unset($_SESSION['mtype']);
?>
</body>
</html>