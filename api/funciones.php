<?php
session_start();
date_default_timezone_set('America/Chihuahua');
//header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: text/html; charset=UTF-8');

$debug = "";
error_reporting(E_ALL); ini_set('display_errors', '0');
$debug = ""; $title_final = ""; $maxsize = 5;
if($_REQUEST['debug'] == ":{" || $debug_mode == "1"){ error_reporting(E_ALL); ini_set('display_errors', '1'); $debug_mode = "1"; }

include_once ("db.php");

if(!function_exists('apache_request_headers')) { function apache_request_headers(){ $headers = []; foreach ($_SERVER as $name => $value) { if (substr($name, 0, 5) == 'HTTP_') {
$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
} } return $headers; } }
$GetHeaders = apache_request_headers();

$CF_IPCountry = $GetHeaders['CF-IPCountry'];
$HTTP_CF_IPCOUNTRY = $_SERVER['HTTP_CF_IPCOUNTRY'];
if($CF_IPCountry == "CN"){ header("HTTP/1.0 404 Not Found"); exit(); }
if($HTTP_CF_IPCOUNTRY == "CN"){ header("HTTP/1.0 404 Not Found"); exit(); }

function Valida($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
function Valida_utf8($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
//$data = utf8_decode($data);
return $data;
}

function req_param($param){ $mysqli = $GLOBALS['mysqli'];
$req = $mysqli->real_escape_string(Valida_utf8($_REQUEST[$param]));
return $req;
}

$random = substr(md5(uniqid(rand())),0,5);
$local_path = __DIR__;
//include_once("app/lib/Encrypt_Decrypt.php");

function url_server() {
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
$isSecure = true;
}
$HTTP = $isSecure ? 'https:' : 'http:';
$server = $_SERVER["SERVER_NAME"];
$url_server = "//".$server."";
//$server_url = $HTTP."//".$server."";
return $url_server;
}

function ip() {
$pss = $_SERVER['HTTP_X_FORWARDED_FOR'];
$alt_ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $alt_ip = $_SERVER['HTTP_CF_CONNECTING_IP']; }
//else if (isset($_SERVER['HTTP_CLIENT_IP'])) { $alt_ip = $_SERVER['HTTP_CLIENT_IP']; }
else if (isset($_SERVER['REMOTE_ADDR'])) { $alt_ip = $_SERVER['REMOTE_ADDR']; }
//return $alt_ip;
if ($pss == "") { $IP = $alt_ip; } else { $IP = $pss; }
return $IP;
}

function user_agent() {
return $_SERVER['HTTP_USER_AGENT'];
}

?>