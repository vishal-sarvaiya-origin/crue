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

    $contact = $_POST['contact'];
    $relationship = $_POST['relationship'];
    $gender = $_POST['gender'];

    //$user = $db->SELECT('tbl_users',null,array("mobile" => $contact));
    //$total_rows = mysqli_num_rows($user);
    $data['contact'] = $contact;
    $data['relationship'] = $relationship;
    $data['gender'] = intval($gender);

    $new_user = $db->INSERT('tbl_users', $data);
    if ($new_user == 1) {
        $response["MESSAGE"] = "USER CREATED SUCCESSFULLY";
        $response["STATUS"] = 201;
    } else {
        $response["MESSAGE"] = "FAILED";
    }
} else {
    $response["MESSAGE"] = "INVALID REQUEST";
    $response["STATUS"] = 400;
}


echo json_encode($response);
