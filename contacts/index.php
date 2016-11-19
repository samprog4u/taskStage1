<?php
/*
*** This document is an htaccess router trick whenever an doing a small project
*** which i dont want to use those PHP frameworks such as Laravel, Codeigniter e.t.c
*** It handles the URL and the navigational trick before it render it for view.
*** Oloruntoba Samson A.K.A Samprog ...... coding is like honey.....
*/
session_start();
$_SESSION['err']="The page you requested does not exist!";
$basefolder = 'contacts';
$_SESSION['basefolder']=$basefolder;
$request = $_SERVER['REQUEST_URI'];
$request = explode('/', substr($request, 1));
if (!empty($basefolder) && $request[0] == $basefolder)
	array_splice($request, 0, 1);
	
#echo $_SERVER['REQUEST_URI'];
#var_dump($request);
#var_dump(empty($request));
#exit;

//This is where the page is been extarcted for a specific files to render
$path = "/".((!empty($basefolder))? $basefolder.'/' : '');
$breadcrumb = 'You are here: <li><a href="'.$path.'">Home</a></li>';
$page = 'home';
for ($k=0; $k<count($request); $k++) {
	if (empty($request[$k])) break;
	$page_title = ucwords(str_replace('_', ' ', $request[$k]));
	$path .= $request[$k].'/';
	$breadcrumb .= '<li><a href="'.$path.'">'.$page_title.'</a></li>';
	$page = $request[$k];
}
//This is an additional router trick for directories
$route=$_SERVER['REQUEST_URI'];
@$rsplit=split("/",$route);
@$cnt=@count($rsplit);
$nPage="";
for($i=0;$i<$cnt;$i++)
{
	if($rsplit[$i]=="cls")
	{
		for($j=$i+1;$j<$cnt;$j++)
		{
			$nPage=$nPage."/".$rsplit[$j];
		}
//		$cnt=$cnt-1;
	}
}
@$nPage=substr($nPage,1,strlen($nPage)-2);
if($nPage==""){$nPage=$page;}
//end additional router
//for styles and files breaking down (it may be inside a directory or not, this will cater for it)
$ext_files="";
for($m=1;$m<$cnt-2;$m++)
{
	$ext_files=$ext_files . "../";
}
//echo $nPage;
//rendering the view by including it
if (@!(include $nPage.'.php')) {
	$breadcrumb = 'Go back to the <li><a href="/'.((!empty($basefolder))? $basefolder.'/' : '').'">Homepage</a></li>';
	$page_title = 'Bad Request';
	include 'errorpage.php';
}
?>