<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_fault_desc'])) {
    $fault_desc = $_POST['edit_fault_desc'];
    $datetime = $_POST['datetime'];
    $rectification = $_POST['rectification'];
    $components = $_POST['components'];
    $main_part = $_POST['main_part'];
    $id = $_GET['fault_id'];
    include_once 'db_con.php';
    $sql = "UPDATE `faults` SET `occured_on`='$datetime', `main_part`='$main_part', `fault_desc`='$fault_desc', `components`='$components', `rectification`='$rectification'  WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    // echo mysqli_error($con);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "Fault id $id updated";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, Fault id $id not updated";
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
    <title>Fault details</title>
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
    function url_to_clickable_link($plaintext)
    {
        return preg_replace(
            '%(https?|ftp)://([-A-Z0-9-./_*?&;=#]+)%i',
            '<a target="blank" rel="nofollow" href="$0" target="_blank">$0</a>',
            $plaintext
        );
    }
    // if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['fault_id'])) {

    $fault_id = $_GET['fault_id'];
    include_once 'db_con.php';
    $sql = "SELECT * FROM `faults` WHERE `id`='$fault_id'";
    $result = mysqli_query($con, $sql);
    $rowNos = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $occured_on = $row['occured_on'];
    $machine = $row['machine'];
    $main_part = $row['main_part'];
    $fault_desc = $row['fault_desc'];
    $rectification = $row['rectification'];
    $rectification = url_to_clickable_link($rectification);
    $components = $row['components'];
    $entry_done_by = $row['entry_done_by'];
    // }
    ?>
    <div class="container my-3">

        <?php
        echo "<a href='fault_history.php?machine=$machine' class='btn btn-primary'><- Return to all $machine faults</a> <br> <br>
              <h4><u>M&P Name</u></h4>
              <p style='white-space: pre-wrap'>$machine</p>
              <h4><u>Fault occured on</u></h4>
              <p style='white-space: pre-wrap'>$occured_on</p>
              <h4><u>Main part affected by fa</u>ult</h4>
              <p style='white-space: pre-wrap'>$main_part</p>
              <h4><u>Fault Description</u></h4>
              <p style='white-space: pre-wrap'>$fault_desc</p>
              <h4><u>Rectification</u></h4>
              <p style='white-space: pre-wrap'>$rectification</p>
              <h4><u>Compents Replaced/New</u></h4>
              <p style='white-space: pre-wrap'>$components</p>
              <h4><u>Entry done by</u></h4>
              <p style='white-space: pre-wrap'>$entry_done_by</p>";
        ?>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>