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

    $contact = $_POST['contact'];

    $user = $db->SELECT('tbl_users', null, array("contact" => $contact));
    $total_rows = mysqli_num_rows($user);

    if (intval($total_rows) > 0) {

        $array = array();
        $array["Users"] = array();

        while ($row = $user->fetch_assoc()) {
            $user_data[] = $row;
        }
        $response["MESSAGE"] = "DATA FOUND";
        $response["STATUS"] = 200;
        $response["TOTAL_RECORD"] = intval($total_rows);
        $response["DATA"] = $user_data;

        http_response_code(200);
    } else {

        $response["MESSAGE"] = "DATA NOT FOUND";
        $response["STATUS"] = 404;
    }
} else {
    $response["MESSAGE"] = "INVALID REQUEST";
    $response["STATUS"] = 400;
}


echo json_encode($response);
