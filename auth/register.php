<?php
header('Content-Type: application/json');
require_once "../Database/db.php";

if (isset($_POST['checkEmail'])){
    $email = $_POST['email'];
    $stmt = $db->prepare("select * from users where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if ($row == null) {

        $return = array(
            'message' => "success"
        );
    } else {
        $return = array(
            'message' => "Account is reserved"
        );
    }
    $stmt->close();
    echo (json_encode($return));
}

if (isset($_POST['register'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthdate'];
    $ava = $_POST['ava'];

    if (empty($email) || empty($password) || empty($firstName) || empty($lastName) || empty($birthDate)){
        echo (json_encode(array('message'=>'Please, fill all fields')));
        return;
    }
    if ($ava == ''){
        $ava = 'https://image.flaticon.com/icons/svg/2919/2919600.svg';
    }


    $stmt = $db->prepare("insert into users(email, password, firstName, lastName, birthdate, ava) values(?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssss", $email, $password, $firstName, $lastName, $birthDate, $ava);

    if ($stmt->execute()){
        session_start();
        $_SESSION['user'] = array(
            'id' => mysqli_insert_id($db),
            'email' => $email,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthDate' => $birthDate,
            'ava' => $ava
        );
        $return = array('message'=>"success");
    }else{
        $return = array('message'=>'Registration error');
    }
    $stmt->close();
    echo json_encode($return);
}
