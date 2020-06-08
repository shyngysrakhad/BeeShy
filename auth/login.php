<?php

header('Content-Type: application/json');
require_once "../Database/db.php";

if(isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)){
        echo (json_encode(array('message'=>'Please, fill all fields')));
        return;
    }


    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if ($row != null && $row['email'] != null) {
        session_start();
        $_SESSION['user'] = array(
            'id' => $row['user_id'],
            'email' => $email,
            'password' => $password,
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'birthDate' => $row['birthdate'],
            'description' => $row['description'],
            'ava' => $row['ava']
        );

        $return = array(
            'message' => "success"
        );
    } else {
        $return = array(
            'message' => "Login or password incorrect!"
        );
    }

    $stmt->close();
}
else{
    $return = array(
        'message' => "Login attempt denied."
    );
}
echo (json_encode($return));