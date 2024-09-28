<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,  Origin, Content-Type,');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case "GET":
        if (isset($_GET['id'])) {
            $users = getUsers($_GET);
            echo $users;
        } else {
            $usersList = getUsersList();
            echo $usersList;
        }
        break;
    case 'POST':
        $inputData = json_decode(file_get_contents("php://input"), true);
        if (empty($inputData)) {
            $storeUsers = storeUsers($_POST);
        } else {
            $storeUsers = storeUsers($inputData);
        }
        echo $storeUsers;
        break;
    case 'PUT':
        $inputData = json_decode(file_get_contents("php://input"), true);
        if (empty($inputData)) {
            $updateUsers = updateUsers($_POST, $_GET);
        } else {
            $updateUsers = updateUsers($inputData, $_GET);
        }
        echo $updateUsers;
        break;
    case "DELETE":
        $deleteUsers = deleteUsers($_GET);
        echo $deleteUsers;
        break;
    default:
        $data = [
            'status' => 400,
            'message' => $requestMethod . 'Method not Allowed',
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
}