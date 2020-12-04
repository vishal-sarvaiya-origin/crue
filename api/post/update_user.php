<?php

error_reporting(0);
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

    $first_name = addslashes($_POST['first_name']);
    $last_name = addslashes($_POST['last_name']);
    $age = intval($_POST['age']);

    $data['first_name'] = $first_name;
    $data['last_name'] = $last_name;
    $data['age'] = $age;

    $update_user = $db->UPDATE('tbl_users', $data, array("id" => $user_id));
    if ($update_user == 1) {
        $response["MESSAGE"] = "USER UPDATED SUCCESSFULLY";
        $response["STATUS"] = 204;
    } else {
        $response["MESSAGE"] = "FAILED";
    }
} else {
    $response["MESSAGE"] = "INVALID REQUEST";
    $response["STATUS"] = 400;
}


echo json_encode($response);
