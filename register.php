<?php
if(isset($_POST["submit"])) {
    $name = $_POST["pname"];
    $email = $_POST["email"];
    $pnumber = $_POST["phone"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $blood = $_POST["bgrp"];
    $uname = $_POST["usname"];
    $password = $_POST["pwd"];
    $cpassword = $_POST["cpsw"];

    require_once 'config.php';

    $emptyInputs = emptyInputsReg($name, $email, $pnumber, $weight, $height, $blood, $uname, $password, $cpassword);
    $invalidUid = invalidUid($uname);
    $invalidEmail = invalidEmail($email);
    $pwdMatch = pwdMatch($password, $cpassword);
    $uidExists = uidExists($conn, $uname, $email);

    if($emptyInputs !== false) {
        header("Location:../index.html?error=emptyinputs");
        exit();
    }

    if($invalidUid !== false) {
        header("Location:../index.html?error=invaliduid");
        exit();
    }

    if($invalidEmail !== false) {
        header("Location:../index.html?error=invalidemail");
        exit();
    }

    if($pwdMatch !== false) {
        header("Location:../index.html?error=passworddoes not match");
        exit();
    }

    if($uidExists !== false) {
        header("Location:../index.html?error=usernametaken");
        exit();
    }
    createUser($name, $email, $pnumber, $weight, $height, $blood, $uname, $password);

}
else {
     header('location:./login.html');
     exit();
}
?>

<!DOCTYPE html>
<head>
    <title>register|Fit Well</title>
    <link rel="stylesheet" href="./Styles.css">
</head>

<body class="bg-img">
    <div class="container">
        <h2>register</h2>
        <form action="register.php" method="post">
          <input type="text" name="pname" placeholder="Name" required>
          <br>
          <input type="email" name="email" placeholder="Email" required>
          <br>
          <input type="text" name="phone" placeholder="Phone" required>
          <br>
          <input type="number" name="weight" placeholder="Weight" required>
          <br>
          <input type="number" name="height" placeholder="Height" required>
          <br>
          <input type="text" name="bgrp" placeholder="Blood group" required>
          <br>
          <input type="text" name="usname" placeholder="Username" required>
          <br>
          <input type="password" name="psw" placeholder="Password" required>
          <br>
          <input type="password" name="cpsw" placeholder="Confirm password" required>
          <br>
          <br>
          <button type="submit">Register</button>
          <p><a href="login.php">Already have an account?</a></p>
        </form>
      </div>
</body>
</html>