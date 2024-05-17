<?php
function emptyInputsReg($name, $email, $pnumber, $weight, $height, $blood, $uname, $password, $cpassword) {
    $result;
    if (empty($name) || empty($email) || empty($pnumber) || empty($weight) || empty($height) || empty($blood) ||empty($uname) || empty($password) || empty($cpassword)) {
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function invalidUid($uname) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $uname)) {   
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, filter_validate_email)) {   
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $cpassword) {
    $result;
    if ($password !== $cpassword) {   
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $uname, $email){
    $sql = "SELECT * FROM user_dt WHERE username = ? email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../register.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ss", $uname, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createUser($name, $email, $pnumber, $weight, $height, $blood, $uname, $password);{
    $sql = "INSERT INTO user_dt (name, email, phone, weight, height, b_group, username,	password) VALUES (?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../register.php?error=stmtfailed");
        exit();
    }
    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $pnumber, $weight, $height, $blood, $uname, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../login.php?error=none");
    exit();
}

function emptyInputs($username, $password) {
    $result;
    if (empty($uname) || empty($password)) {
        $result = true;
    }else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $uname, $password){
    uidExists($conn, $uname, $uname);
    if ($uidExists === false ) {
        header("Location:../register.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists['password'];
    $checkPwd = password_verify($password, $pwdHashed);

    if ($checkPwd === false){
        header("Location:../login.php?error=wronglogin");
        exit();
    } elseif ($checkPwd === true) {
        _start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["usname"] = $uidExists["username"]
        $_SESSION["username"] = $uidExists["name"]
        header("Location:../index.html");
        exit();
    }
}