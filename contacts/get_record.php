<?php
//including my connection and database channels with all sort of server side validation function
include_once("connect/dbconnect.php");
include_once("connect/validators.php");

//instantiating the classes instance in the include files
$contact=new ContactList;
$validator=new validator;

//validating user inputs for some vital attacks including a valid email address
$id = $validator->TestInput(trim($_POST['id']));
//Retrieving the particular record if exist and if not 0 will be outputed and is been traped in my json file.
$getValue = $contact->SelectByIdentity('contact_book', '*', 'id', $id);
 if($contact->row_num < 1)
 {
 	//record not found, maybe user has alter the unique id specified for geting record by developer tools (its return in a json format)
 	echo json_encode("0");
 	exit();
 }
 
 //Record found and sending the record to the modified page for further processing (its return in a json format)
 echo json_encode($getValue);
?>