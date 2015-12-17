<?php
$url = "http://www.ipmango.com/api/myip";
$ch = curl_init();
     
if($ch === false)
{
    die('Failed to create curl object');
}
     
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 
//proxy details
curl_setopt($ch, CURLOPT_PROXY, 'localhost:9050');
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
 
$data = curl_exec($ch);
curl_close($ch);
 
echo $data;
?> <br>

<?php
	
	echo file_get_contents('http://www.ipmango.com/api/myip');
	
	?>