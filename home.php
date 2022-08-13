<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['machine'])) {
    $machine = $_POST['machine'];
    header("Location: fault_history.php?machine=$machine");
}
$showAlert = false;
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>MWKPD Faults</title>
</head>

<body>
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container my-5 col-xs-8 col-md-3">
        <form method='POST' action='home.php'>
            <div class='mb-3'>
                <label for='machine' class='form-label float-start '><b>Select M&P to view faults</b></label>
                <select id="machine" name="machine" class="form-control">
                    <option value>Select an option</option>
                    <option value="PWL">Pit Wheel Lathe</option>
                    <option value="Pit_Jack">Pit Jack</option>
                    <option value="Mobile_Jack_Pfaff">Mobile Jack Pfaff</option>
                    <option value="Mobile_Jack_Auto_Lift">Mobile Jack Auto Lift</option>
                    <option value="WSL_1-2_Open_End_Crane">WSL 1&2 Open End Crane 15/2 T</option>
                    <option value="WSL_1-2_Dead_End_Crane">WSL 1&2 Dead End Crane 15/2 T</option>
                    <option value="WSL_3-4_Open_End_Crane">WSL 3&4 Open End Crane 3.2 T</option>
                    <option value="WSL_3-4_Dead_End_Crane">WSL 3&4 Dead End Crane 3.2 T</option>
                    <option value="WSL_5-6_Open_End_Crane">WSL 5&6 Open End Crane 15/2 T</option>
                    <option value="WSL_5-6_Dead_End_Crane">WSL 5&6 Dead End Crane 5 T</option>
                    <option value="IBL-1_Crane">IBL 1 Crane 1.5 T</option>
                    <option value="IBL-2_Crane">IBL 3 Crane 1.5 T</option>
                    <option value="ETU_Crane">ETU Crane 5 T</option>
                    <option value="PWL_Crane">PWL Crane 3.2 T</option>
                    <option value="PWL_Shunter">Pit Wheel Lathe Shunter</option>
                </select>
            </div>
            <center>
            <button type='submit' class='btn btn-primary'>Submit</button>
            </center>
        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>