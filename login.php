<?php
include ("db.php");
//header("Content-Type:application/json");
echo "email: ";
echo $_POST['email'] . "</br>";
echo "password: ";
echo $_POST['password'] . "</br>" ;


if (isset($_POST['email']) && $_POST['password'] != "") {
    include('db.php');
    $pass = $_POST[`password`];
    $email = $_POST['email'];
    
    $result = $mysqli->query("SELECT `password` FROM `user` WHERE `email` = '$email';");
    if ($result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo $row['password'];
        $dbpass = $row['password'];
            if ( $dbpass == $pass ) {
                echo "mkdlknsldfnkljnsdfkjn";
                $response[`response`] = $email;
                $json_response = json_encode($response);
                echo $json_response;
            } else {

            }
        $mysqli->kill($mysqli->thread_id);
        $mysqli->close();
    } else {
        response(NULL, NULL, 200, "No Record Found");
    }
} else {
    response(NULL, NULL, 400, "Invalid Request");
}

function response($order_id, $amount, $response_code, $response_desc)
{
    $response['order_id']      = $order_id;
    $response['amount']        = $amount;
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;
    
    $json_response = json_encode($response);
    echo $json_response;
}
?>