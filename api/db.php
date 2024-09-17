<?php
$server = $_SERVER["HTTP_HOST"]; //server + puerto = localhost:8080
$server_name = $_SERVER["SERVER_NAME"]; //solo server = localhost

$db_server_main_db = "localhost"; $db_username = "mpcref8t";
$db_username_main_db = $db_username."_promess";
$db_password_main_db = "q808Xq8G1ho5";
$db_name_main_db = $db_username."_promess";

$mysqli = new mysqli($db_server_main_db, $db_username_main_db, $db_password_main_db, $db_name_main_db);
if ($mysqli -> connect_errno) {
    $error_db = "Lo sentimos pero se presento un error al conectarse en la base de datos MySQLi (" . $mysqli -> connect_errno . ") " . $mysqli -> connect_error."<br>\n";
    echo $error_db; exit();
}

?>