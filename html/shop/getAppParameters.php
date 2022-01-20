<?php

require 'AWSSDK/aws.phar';

//Get the application environment parameters from the Parameter Store.

$az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
$region = substr($az, 0, -1);

$ssm_client = new Aws\Ssm\SsmClient([
    'version' => 'latest',
    'region'  => $region
]);

$result = $ssm_client->GetParametersByPath(['Path' => '/shop']);

$showServerInfo = "";
$timeZone = "";
$currency = "";
$db_url = "";
$db_name = "";
$db_user = "";
$db_password = "";

foreach($result['Parameters'] as $p) {
    if ($p['Name'] == '/shop/showServerInfo') $showServerInfo = $p['Value'];
	if ($p['Name'] == '/shop/timeZone') $timeZone = $p['Value'];
    if ($p['Name'] == '/shop/currency') $currency = $p['Value'];
    if ($p['Name'] == '/shop/dbUrl') $db_url = $p['Value'];
    if ($p['Name'] == '/shop/dbName') $db_name = $p['Value'];
    if ($p['Name'] == '/shop/dbUser') $db_user = $p['Value'];
    if ($p['Name'] == '/shop/dbPassword') $db_password = $p['Value'];
}

?>
