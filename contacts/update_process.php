<?php
//checking the post URL may be its from Copy and paste URL or from a Update button
if(!isset($_POST['submit']) || $_POST['submit'] == "")
{
	header('location: errorpage');
	exit();
}
ob_start();
session_start();
//Accession the token generated from add form module and validating it for genueity
$token = $_SESSION['update_contact_token'];
unset($_SESSION['update_contact_token']);

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
$id = $validator->TestInput(trim($_POST['_token_id']));
$fullname = $validator->TestInput(trim($_POST['fullname']));
$email = $validator->IsValidEmail($validator->TestInput(trim($_POST['email'])));
if ($email === false) 
{
    // Not a valid email address! Handle this invalid input here.
    $_SESSION['msg'] = 'Invalid email address, check and try again!';
 	$_SESSION['mtype'] = 'error_strings';
 	header('location: list');
 	exit();
}

 //populating my data for processing
 $data = array(
				'names' => $fullname,
                'email' => $email
                );

//record not found, maybe user has alter the unique id specified for geting record by developer tools (its return in a json format)
 $check = $contact->SelectByIdentity('contact_book', '*', 'id', $id);
 if($contact->row_num < 1)
 {
 	$_SESSION['msg'] = 'Invalid operation or modification, check and try again!';
 	$_SESSION['mtype'] = 'error_strings';
 	header('location: list');
 	exit();
 }

//cross checking if the email already exist because duplicate email not allowed
//Reason: Two or more person cannot have the same email address
 $check_duplicate_email = $contact->SelectByIdentity('contact_book', '*', 'email', $email);
 if($contact->row_num > 0)
 {
    foreach ($check_duplicate_email as $result_dup) 
    {
        $unique_id = $result_dup['id'];
    }

    if($id != $unique_id)
    {
        $_SESSION['msg'] = 'Email already exist for another user, check and try again!';
        $_SESSION['mtype'] = 'error_strings';
        header('location: list');
        exit();
    }
 }
 
 //Updating data after thorough validation and sanitation of user's inputs
 //Moreso, PDO Prepared statements is used in the database channel for SQL injections
 $update = $contact->UpdateDB('contact_book', $data, 'id', $id);
 $_SESSION['msg'] = 'Contact successfully updated!';
 $_SESSION['mtype'] = 'success_strings';
 header('location: list');
 
?>