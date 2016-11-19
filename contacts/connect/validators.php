<?php
	/**
	* This is a Server side validation class and functions that serve as the
	* validators of different web security attacks such as CSRF, XSS and
	* someother unforseen attacks
	*** Oloruntoba Samson A.K.A Samprog ...... coding is like honey.....
	*/
	class validator
	{	
		function TestInput($data) 
		{
			$data = trim($data);
			$data = strip_tags($data);
			if(get_magic_quotes_gpc())
			{
				$data = stripslashes($data);
			}
			$data = htmlspecialchars($data);
			$data = $this->noHTML($data);
			return $data;
		}
		
		function RemoveBadChar($data)
		{
  			return filter_var($data, FILTER_SANITIZE_EMAIL);
		}
		
		function IsValidEmail($data)
		{
			return filter_var($data, FILTER_VALIDATE_EMAIL);
		}

		function noHTML($input, $encoding = 'UTF-8')
		{
			//$input = strip_tags($input);
		    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
		}
	}
?>