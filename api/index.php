<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=ISO-8859-1', true);
include_once("funciones.php");

$get_action = req_param('action');
$get_estado = req_param('estado');
$get_ciudad = req_param('ciudad');
$get_sucursal = req_param('sucursal');
$get_q = req_param('q');

$api_response = "";

if($get_action == ""){
$api_response = array("status"=>"ERROR","msg"=>"Falta ?action=valor");

} else if($get_action == "estados"){

    $estados_a = array();
    $query_Q1 = "SELECT * FROM `Estados` WHERE `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    $result_Q1 = $mysqli->query($query_Q1);
    $num_Q1 = $result_Q1->num_rows;
    if ($num_Q1 >= 1) {
    while($row_Q1 = $result_Q1->fetch_array(MYSQLI_ASSOC)){
        $estados_a[] = $row_Q1;
    } }
    $api_response = array("status"=>"OK","msg"=>$estados_a,"query"=>$query_Q1);

} else if($get_action == "ciudades"){

    $ciudades_a = array();
    if($get_estado != ""){
        $query_Q1 = "SELECT * FROM `Ciudades` WHERE `Estado` = '".$get_estado."' AND `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    } else {
        $query_Q1 = "SELECT * FROM `Ciudades` WHERE `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    }
    $result_Q1 = $mysqli->query($query_Q1);
    $num_Q1 = $result_Q1->num_rows;
    if ($num_Q1 >= 1) {
    while($row_Q1 = $result_Q1->fetch_array(MYSQLI_ASSOC)){
        $ciudades_a[] = $row_Q1;
    } }
    $api_response = array("status"=>"OK","msg"=>$ciudades_a,"query"=>$query_Q1);

} else if($get_action == "sucursales"){

    $sucursales_a = array();
    if($get_estado != "") {
        $query_Q1 = "SELECT * FROM `Sucursales` WHERE `Estado_Id` = '" . $get_estado . "' AND `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    } else if($get_ciudad != ""){
        $query_Q1 = "SELECT * FROM `Sucursales` WHERE `Ciudad` = '".$get_ciudad."' AND `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    } else {
        $query_Q1 = "SELECT * FROM `Sucursales` WHERE `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";
    }
    $result_Q1 = $mysqli->query($query_Q1);
    $num_Q1 = $result_Q1->num_rows;
    if ($num_Q1 >= 1) {
    while($row_Q1 = $result_Q1->fetch_array(MYSQLI_ASSOC)){
        $sucursales_a[] = $row_Q1;
    } }
    $api_response = array("status"=>"OK","msg"=>$sucursales_a,"query"=>$query_Q1);

} else if($get_action == "asesores"){
//https://drive.google.com/drive/u/0/folders/1WKSUt1dEvxbiAKn2TFnCY4SrS0p4avmY

    $asesores_a = array(); $q_q1 = "";

    if($get_estado != "") { $q_q1 .= "`Estado_Id` = '".$get_estado."' AND "; }
    if($get_ciudad != "") { $q_q1 .= "`Ciudad` = '".$get_ciudad."' AND "; }
    if($get_sucursal != "") { $q_q1 .= "`Oficina` = '".$get_sucursal."' AND "; }
    if($get_q != "") { $q_q1 .= "`Nombre` LIKE '%".$get_q."%' AND "; }
    $query_Q1 = "SELECT * FROM `Asesores` WHERE ".$q_q1." `Estatus_Id` = 'Activo' ORDER BY `id` ASC;";

    $result_Q1 = $mysqli->query($query_Q1);
    $num_Q1 = $result_Q1->num_rows;
    if ($num_Q1 >= 1) {
    while($row_Q1 = $result_Q1->fetch_array(MYSQLI_ASSOC)){
        $row_Q1['Video_Url'] = "https://videos.pexels.com/video-files/4614907/4614907-uhd_2560_1440_30fps.mp4";

        $asesores_a[] = $row_Q1;

    } }
    $api_response = array("status"=>"OK","msg"=>$asesores_a,"query"=>$query_Q1);

} else {

    $api_response = array("status"=>"ERROR","msg"=>"Incorrecto ?action=COSA");

}

echo json_encode($api_response);

?>