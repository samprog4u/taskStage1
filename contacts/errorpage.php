<?php
	$error = $_SESSION['err'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error Page</title>
<link rel="stylesheet" href="<?php echo $ext_files;?>css/error.css" type="text/css">
</head>

<body>
	
	<div class="error">
		<div id="outline">
		<div id="errorboxoutline">
			<div id="errorboxheader"><?php echo "Error 404: " . $error; ?></div>
			<div id="errorboxbody">
			<p><strong>You may not be able to visit this page because of:</strong></p>
			<ol>
				<li>an <strong>out-of-date bookmark/favourite</strong></li>
				<li>a search engine that has an <strong>out-of-date listing for this site</strong></li>
				<li>a <strong>mistyped address</strong></li>
				<li>you have <strong>no access</strong> to this page</li>
				<li>The requested resource was not found.</li>
				<li>An error has occurred while processing your request.</li>
			</ol>
			<p><strong>Please try one of the following pages:</strong></p>
			<ul>
				<li><a href="http://localhost/contacts/" title="Go to the Home Page">Home Page</a></li>
			</ul>
			<p>If difficulties persist, please contact the System Administrator of this site and report the error below..</p>
			<div id="techinfo">
			<p>Category not found</p>
			<p>
							</p>
			</div>
			</div>
		</div>
		</div>
	</div>

</body>
</html>