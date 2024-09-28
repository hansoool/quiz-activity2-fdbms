<?php

require '../inc/dbcon.php';


function error422($message)
{

    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
function storeUsers($usersInput)
{

    global $conn;

    $f_name = mysqli_real_escape_string($conn, $usersInput['f_name']);
    $l_name = mysqli_real_escape_string($conn, $usersInput['l_name']);
    $is_Admin = mysqli_real_escape_string($conn, $usersInput['is_Admin']);

    if (empty(trim($f_name))) {


        return error422('Enter your First Name');

    } elseif (empty(trim($l_name))) {

        return error422('Enter your Last Name');
    } elseif (empty(trim($is_Admin))) {

        return error422('Are you an admin?');
    } else {
        $query = "INSERT INTO users (f_name,l_name,is_Admin) VALUES ('$f_name', '$l_name', '$is_Admin')";
        $result = mysqli_query($conn, $query);


        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'User record created successfully!',
            ];

            header("HTTP/1.0 201 User record created successfully!");
            return json_encode($data);

        } else {
            $data = [
                'status' => 201,
                'message' => 'Internal Server Error',
            ];

            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }


}
function getUsersList()
{

    global $conn;


    $query = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {

        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'User Record Fetched Successfully',
                'data' => $res
            ];

            header("HTTP/1.0 200 User Record Fetched Successfully");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Records Found',
            ];

            header("HTTP/1.0 404 No Records Found");
            return json_encode($data);
        }

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];

        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}

function getUsers($usersParams)
{

    global $conn;
    if ($usersParams['id'] == null) {

        return error422('No Users Found');
    }
    $userId = mysqli_real_escape_string($conn, $usersParams['id']);

    $query = "SELECT * FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'User record fetched successfully',
                'data' => $res
            ];

            header("HTTP/1.0 200 User record fetched successfully");
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'User record not found',
            ];

            header("HTTP/1.0 404 User record not found");
            return json_encode($data);

        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];

        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function updateUsers($usersInput, $usersParams)
{

    global $conn;

    if (!isset($usersParams['id'])) {
        return error422('User id not found in URL');

    } elseif ($usersParams['id'] == null) {

        return error422('Enter the user id');
    }

    $usersId = mysqli_real_escape_string($conn, $usersParams['id']);

    $f_name = mysqli_real_escape_string($conn, $usersInput['f_name']);
    $l_name = mysqli_real_escape_string($conn, $usersInput['l_name']);
    $is_Admin = mysqli_real_escape_string($conn, $usersInput['is_Admin']);

    if (empty(trim($f_name))) {


        return error422('Enter your First Name');

    } elseif (empty(trim($l_name))) {

        return error422('Enter your Last Name');
    } elseif (empty(trim($is_Admin))) {

        return error422('Are you an admin?');
    } else {
        $query = "UPDATE users SET f_name='$f_name', l_name='$l_name', is_Admin='$is_Admin' WHERE id='$usersId' LIMIT 1";
        $result = mysqli_query($conn, $query);


        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'User record updated successfully!',
            ];

            header("HTTP/1.0 200 User record updated successfully!");
            return json_encode($data);

        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];

            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }


}

function deleteUsers($usersParams)
{

    global $conn;
    if (!isset($usersParams['id'])) {
        return error422('User id not found in URL');

    } elseif ($usersParams['id'] == null) {

        return error422('Enter the user id');
    }

    $usersId = mysqli_real_escape_string($conn, $usersParams['id']);

    $query = "DELETE FROM users WHERE id ='$usersId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'User deleted successfully!',
        ];

        header("HTTP/1.0 200 User deleted successfully!");
        return json_encode($data);


    } else {
        $data = [
            'status' => 404,
            'message' => 'User record not found',
        ];

        header("HTTP/1.0 404 User record not found");
        return json_encode($data);

    }
}
?>