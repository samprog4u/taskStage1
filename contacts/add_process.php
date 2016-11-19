<?php
//checking the post URL may be its from Copy and paste URL or from a Save button
if(!isset($_POST['submit']) || $_POST['submit'] == "")
{
	header('location: errorpage');
	exit();
}
ob_start();
session_start();
//Accession the token generated from add form module and validating it for genueity
$token = $_SESSION['add_contact_token'];
unset($_SESSION['add_contact_token']);

if (!$token || $_POST['_token'] !=$token) 
{
   // log potential CSRF attack.
	header('location: errorpage');
	exit();
}
//including my connection and database channels with all sort of server side validation function
include_once("connect/dbconnect.php");
include_once("connect/validators.php");

//instantiating the classes instance in the include files
$contact=new ContactList;
$validator=new validator;

//validating user inputs for some vital attacks including a valid email address
$fullname = $validator->TestInput(trim($_POST['fullname']));
$email = $validator->IsValidEmail($validator->TestInput(trim($_POST['email'])));
if ($email === false) 
{
    // Not a valid email address! Handle this invalid input here.
    $_SESSION['msg'] = 'Invalid email address, check and try again!';
 	$_SESSION['mtype'] = 'error_strings';
 	header('location: add');
 	exit();
}

//populating my data for processing
$date_created = strtotime(date('d-m-Y h:i:s'));

 $data = array(
				'names' => $fullname,
                'email' => $email,
                'time' => $date_created
                );

//cross checking if the email already exist because duplicate email not allowed
//Reason: Two or more person cannot have the same email address
 $check = $contact->SelectByIdentity('contact_book', '*', 'email', $email);
 if($contact->row_num > 0)
 {
 	$_SESSION['msg'] = 'Email already exist, check and try again!';
 	$_SESSION['mtype'] = 'error_strings';
 	header('location: add');
 	exit();
 }
 
 //Inserting data after thorough validation and sanitation of user's inputs
 //Moreso, PDO Prepared statements is used in the database channel for SQL injections
 $insert = $contact->InsertDB('contact_book', $data);
 $_SESSION['msg'] = 'Contact successfully added!';
 $_SESSION['mtype'] = 'success_strings';
 header('location: add');
 
?>