<?
session_start();
include("./phptextClass.php");

/*create class object*/
$phptextObj = new phptextClass();
/*phptext function to genrate image with text*/
//$phptextObj->phpcaptcha('#ec174f','#ec174f',120,40,10,25);
//$phptextObj->phpcaptcha('#ec174f','#fff',100,36,10,25,'#99003d');
$phptextObj->phpcaptcha('#ec174f','#fff',100,36,10,25);

// #162453
// #ec174f