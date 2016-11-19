<?php
    //including only the server side validation function.
    include_once("connect/validators.php");
    $validator=new validator;
    //This page is the common page of this web application, so efficiency and erradicating of repetition then it is created separately
    //so as to be called everytime that is needed
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact List</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>logger/structure.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>css/table.css" />
    <link href="<?php echo $validator->noHTML($ext_files);?>css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo $validator->noHTML($ext_files);?>assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>media/css/demo_table.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $validator->noHTML($ext_files);?>media/themes/smoothness/jquery-ui-1.8.4.custom.css" />
	<link rel="icon" type="image/png" href="<?php echo $validator->noHTML($ext_files);?>media/images/library.png">
    <script src="<?php echo $validator->noHTML($ext_files);?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo $validator->noHTML($ext_files);?>js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo $validator->noHTML($ext_files);?>js/myjquery.js"></script>
    <script src="<?php echo $validator->noHTML($ext_files);?>media/js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo $validator->noHTML($ext_files);?>media/js/jquery.dataTables.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
	    $('#dtable').dataTable();
	})
    </script>
</head>
<body>
<center>
	<div id="header"><h1 class="header-text">Email Contact List</h1>
		<div id="menu-modal">
            <!-- This is for the URLs of the menus -->
			<a href="/<?php if (!empty($basefolder)) echo $validator->noHTML($basefolder).'/' ?>"><button id="b1" class="btn btn-primary ">&nbsp;Home</button></a>
			<a href="/<?php if (!empty($basefolder)) echo $validator->noHTML($basefolder).'/' ?>list"><button id="b2" class="btn btn-primary ">&nbsp;List Contacts</button></a>
			<a href="/<?php if (!empty($basefolder)) echo $validator->noHTML($basefolder).'/' ?>add"><button id="b2" class="btn btn-primary ">&nbsp;Add Contact</button></a>
		</div>
	</div>
</center>