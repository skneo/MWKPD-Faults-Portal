<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
}
$showAlert = false;
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    $user_name = validateInput($_POST['username']);
    $pwd = validateInput($_POST['password']);
    include_once 'db_con.php';
    $sql = "SELECT * FROM `users` WHERE `emp_num`='$user_name' and `password`='$pwd'";
    $result = mysqli_query($con, $sql);
    $rowNos = mysqli_num_rows($result);
    if ($rowNos == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $_SESSION['loggedin'] = true;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['name'] = $name;
        header("Location: home.php");
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Login failed, wrong credentials.";
    }
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>MW KPD Faults Portal</title>
</head>

<body>
    <?php
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container my-5">
        <center>
            <h3>Login to MW KPD Faults Portal</h3>
            <div class="mt-3">
                <img src="images/user.png" alt="user" width="100">
            </div>
            <div class="col-xs-8 col-md-3">
                <form method="POST" action="index.php">
                    <div class="mb-3 ">
                        <label for="username" class="form-label float-start">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3 ">
                        <label for="password" class="form-label float-start">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </center>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>