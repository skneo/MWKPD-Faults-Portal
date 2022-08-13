<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if (isset($_POST['pwd1'])) {
    include 'db_con.php';
    $pwd1 = trim($_POST['pwd1']);
    $pwd2 = trim($_POST['pwd2']);
    $user = $_SESSION['user_name'];
    if (($pwd1 != $pwd2) or $pwd1 == "") {
        echo "<script> alert('Both passwords not matched') </script>";
    } else {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('Y-m-d H:i:s');
        $sql = "UPDATE `users` SET `password`='$pwd1'  WHERE `emp_num`='$user'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $showAlert = true;
            $alertClass = 'alert-success';
            $alertMsg = "Password changed successfully";
            session_destroy();
        } else {
            $showAlert = true;
            $alertClass = 'alert-danger';
            $alertMsg = "Error, Error, Password not changed";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Change Password</title>
</head>

<body>
    <?php include "header.php";
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    ?>
    <script>
        var check = function() {
            var pwd1 = document.getElementById('pwd1').value;
            var pwd2 = document.getElementById('pwd2').value;
            if ((pwd1 == pwd2) && pwd1.trim() != '') {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Both passwords matched';
                document.getElementById('changePwdBtn').disabled = false;
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Both passwords not matched';
                document.getElementById('changePwdBtn').disabled = true;
            }
        }
    </script>
    <center>
        <h4 class="mt-3">Change Password</h4>
        <form method="POST" class="mt-3" style="width: 300px" action="change_password.php">
            <div class=" mb-3">
                <label for="pwd1" class="form-label float-start">Type new password</label>
                <input onkeyup='check();' required type="password" class="form-control" id="pwd1" name="pwd1">
            </div>
            <div class="mb-3">
                <label for="pwd2" class="form-label float-start">Type new password again</label>
                <input onkeyup='check();' required type="password" class="form-control" id="pwd2" name="pwd2">
                <span id='message' class="float-start"></span><br>
            </div>
            <button type="submit" id="changePwdBtn" class="btn btn-success">Submit</button>
        </form>
    </center>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>

</html>