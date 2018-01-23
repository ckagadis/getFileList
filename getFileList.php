<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


static $fileCount = 0;
date_default_timezone_set('UTC');

ob_start();

$date = date("Ymd");
$datePrevious = date("Ymd", strtotime('-1 day'));
$timeStart = date("H00",strtotime('-1 hour'));
$timeEnd = date("H59",strtotime('-1 hour'));
$time2300 = "2300";
$time2359 = "2359";
$hourutc = date("H");
echo "Current Date and Time (UTC)<b> " . date("m/d/Y H:i:sa") . "</b><br />";
echo "Current Hour (UTC)<b> " . $hourutc  . "</b><br /><br />";

date_default_timezone_set('America/Phoenix');
$houraz = date("H");
echo "Current Date and Time (Arizona)<b> " . date("m/d/Y H:i:sa") . "</b><br /><br />";
echo "Current Hour (Arizona)<b> " . $houraz  . "</b><br /><br />";

echo "Time Start <b>" . $timeStart . "</b><br />";
echo "Time End <b>" . $timeEnd . "</b><br />";
echo "Present Day <b>" . $date . "</b><br />";
echo "Previous Day <b>" . $datePrevious . "</b><br /><br />";


$context = stream_context_create(array('ssl' => array('verify_peer' => false, 'allow_self_signed' => true)));

//This $soapClient is used to connect to CUCM's soap RPC format
//$soapClient = new SoapClient("https://hostname:8443/CDRonDemandService/services/CDRonDemand?wsdl",array("login" => "usernameString","password"=> "passwordString",'stream_context' => $context,"trace" => true, "cache_wsdl" => WSDL_CACHE_NONE));

//This $soapClient is used to connect to CUCM's soap docs/literal format
$soapClient = new SoapClient("https://hostname:8443/CDRonDemandService2/services/CDRonDemandService?wsdl",array("login" => "usernameString","password"=> "passwordString",'stream_context' => $context,"trace" => true, "cache_wsdl" => WSDL_CACHE_NONE));

//Query for RPC format
//$data = $soapClient->get_file_list("201608260700","201608260759","1");
//Query for docs/literal format
$data = $soapClient->get_file_list(array('in0' => '201608260700', 'in1' => '201608260759', 'in2' => '1'));


//Use this iteration structure when accessing soap RPC format;
/*
	if(is_array($data->FileName))
	{
		foreach($data->FileName as $name)
		{
			echo '<tr><td>' . $name . '</td></tr><br>';
			$fileCount++;
		}
	}
	else
	{
		echo '<tr><td>'. $data->FileName .'</td></tr>';
		$fileCount++;
	}
*/


//Use this iteration structure when accessing soap docs/literal format;
	if(is_array($data->get_file_listReturn->FileName))
	{
		foreach($data->get_file_listReturn->FileName as $name)
		{
			echo '<tr><td>' . $name . '</td></tr><br>';
			$fileCount++;
		}
	}
	else
	{
		echo '<tr><td>'. $data->get_file_listReturn->FileName .'</td></tr>';
		$fileCount++;
	}


echo "<TABLE>";
$content = ob_get_clean();
echo "Number of CDR Files <b>" . $fileCount . "</b><br />";
echo $content;


?>
