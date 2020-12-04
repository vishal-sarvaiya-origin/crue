<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 0");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/config.php';
$db = new DataBase();

$_REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$response = array();

if ($_REQUEST_METHOD === 'POST') {

    $user_id = $_POST['user_id'];
    $school = addslashes($_POST['school']);

    $data['school'] = $school;

    $update_school = $db->UPDATE('tbl_users', $data, array("id" => $user_id));
    if ($update_school == 1) {
        $response["MESSAGE"] = "SCHOOL UPDATED SUCCESSFULLY";
        $response["STATUS"] = 204;
    } else {
        $response["MESSAGE"] = "FAILED";
    }
} else {
    $response["MESSAGE"] = "INVALID REQUEST";
    $response["STATUS"] = 400;
}


echo json_encode($response);
